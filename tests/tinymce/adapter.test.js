// Mocked asynchronous adapter contract, including timeout and queue recovery.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const root = path.resolve(__dirname, '../../public_html/editors/tinymce');
const elements = Object.fromEntries(['intro','body','stuck','next'].map(id => [id,{value:id,offsetHeight:300,style:{}}]));
const instances = {}, configs = {}, completions = {}, starts = [], timers = new Map();
const listeners = new Map();
const popup = {closed:false,close(){this.closed=true;}};
let timerId = 0;
const context = {
    AdvancedEditor:{api:{}}, geeklogAllowedHtml:{strong:1,em:1,p:{style:1},a:{href:1}},
    geeklogFileManager:false, geeklog:{site_url:'https://example.test'}, URL, geeklogTinyMceBase:'/editors/tinymce/vendor',geeklogTinyMceLanguage:'en',
    document:{getElementById:id=>elements[id]},
    window:{setTimeout:(fn,ms)=>{if(ms===0){queueMicrotask(fn);return 0;} timers.set(++timerId,fn);return timerId;},
        clearTimeout:id=>timers.delete(id),console:{error:()=>{}},
        location:{href:'https://example.test/admin/article.php'},open:()=>popup,
        addEventListener:(name,fn)=>listeners.set(name,fn),removeEventListener:name=>listeners.delete(name),
        setInterval:()=>99,clearInterval:()=>{}},
    tinymce:{
        get:id=>instances[id],
        init:config=>{
            const id=Object.keys(elements).find(key=>elements[key]===config.target);
            starts.push(id); configs[id]=config;
            const events={};
            let value=elements[id].value;
            const editor=instances[id]={
                on:(name,fn)=>events[name]=fn,
                getContent:()=>value,setContent:c=>{value=c;},save:()=>{elements[id].value=value;},
                remove:()=>{delete instances[id];},getContainer:()=>({style:{}})
            };
            config.setup(editor);
            return new Promise(resolve=>{completions[id]=()=>{events.init();resolve([editor]);};});
        }
    }
};
vm.runInNewContext(fs.readFileSync(path.join(root,'functions.js'),'utf8'),context);
const api=context.AdvancedEditor.api.tinymce;
const tick=()=>new Promise(resolve=>setImmediate(resolve));
(async()=>{
    api.newEditor('intro',{toolbar:0});
    api.newEditor('body',{toolbar:2});
    await tick();
    assert.deepEqual(starts,['intro']);
    api.setContent('body','queued body');
    completions.intro();
    await tick();
    assert.deepEqual(starts,['intro','body']);
    completions.body();
    await tick();
    assert.equal(api.getContent('body'),'queued body');
    assert.ok(!configs.intro.toolbar.split(' ').includes('image'));
    assert.ok(!configs.intro.file_picker_callback);
    const protectedContent='[raw]<div>raw</div>[/raw]\n[code]x < y[/code]';
    api.setContent('intro',protectedContent);
    api.changeToolbar('intro','editor-toolbar3');
    await tick();
    completions.intro();
    await tick();
    assert.equal(api.getContent('intro'),protectedContent);
    assert.equal(api.getContent('body'),'queued body');
    assert.equal(configs.intro.license_key,'gpl');
    assert.equal(configs.intro.protect.length,3);
    for(const plugin of configs.intro.plugins.split(' ')) assert.ok(fs.existsSync(path.join(root,'vendor/plugins',plugin,'plugin.min.js')),plugin);
    api.newEditor('stuck',{toolbar:1});
    api.newEditor('next',{toolbar:1});
    await tick();
    api.setContent('stuck','preserved');
    assert.equal(starts.at(-1),'stuck');
    assert.equal(timers.size,1);
    [...timers.values()][0]();
    await tick();
    assert.equal(starts.at(-1),'next');
    assert.equal(api.getContent('stuck'),'preserved');
    assert.equal(elements.stuck.style.visibility,'visible');
    completions.stuck();
    completions.next();
    await tick();
    assert.equal(api.getContent('stuck'),'preserved');
    assert.equal(api.getContent('next'),'next');
    assert.equal(timers.size,0);
    context.geeklogFileManager=true;
    api.changeToolbar('intro','editor-toolbar2');
    await tick();
    completions.intro();
    await tick();
    let selected=[];
    configs.intro.file_picker_callback(url=>selected.push(url),'',{filetype:'image'});
    const receive=listeners.get('message');
    const message=(origin,source,url,type='geeklog-media-selected')=>receive({origin,source,data:{type,url}});
    message('https://evil.test',popup,'https://example.test/images/a.png');
    message('https://example.test',{},'https://example.test/images/a.png');
    message('https://example.test',popup,'javascript:alert(1)');
    message('https://example.test',popup,'https://evil.test/a.png');
    message('https://example.test',popup,'https://user:pass@example.test/a.png');
    message('https://example.test',popup,'/images/a.png','wrong');
    assert.deepEqual(selected,[]);
    message('https://example.test',popup,'/images/a.png');
    assert.deepEqual(selected,['https://example.test/images/a.png']);
    assert.equal(popup.closed,true);
    assert.equal(listeners.has('message'),false);
    console.log('TinyMCE asynchronous adapter and media picker contract passed');
})().catch(error=>{console.error(error);process.exitCode=1;});
