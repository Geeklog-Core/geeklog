// Adapter contract test with a mock engine; not a browser round-trip test.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');
const root = path.resolve(__dirname, '../../public_html/editors/tinymce');
const elements = {intro:{value:'<p>Intro</p>',offsetHeight:300,style:{}}, body:{value:'<p>Body</p>',offsetHeight:300,style:{}}};
const instances = {};
const configs = {};
const context = {
    AdvancedEditor:{api:{}}, geeklogAllowedHtml:{strong:1,em:1,p:{style:1},a:{href:1}},
    geeklogFileManager:false, geeklogTinyMceBase:'/editors/tinymce/vendor',geeklogTinyMceLanguage:'en',
    document:{getElementById:id=>elements[id]},window:{setTimeout:fn=>fn(),console},
    tinymce:{
        get:id=>instances[id],
        init:config=>{
            const id=Object.keys(elements).find(key=>elements[key]===config.target);
            configs[id]=config;
            const events={};
            let value=elements[id].value;
            const editor=instances[id]={
                on:(name,fn)=>events[name]=fn,
                getContent:()=>value,setContent:c=>{value=c;},save:()=>{elements[id].value=value;},
                remove:()=>{delete instances[id];},getContainer:()=>({style:{}})
            };
            config.setup(editor); events.init();
            return Promise.resolve([editor]);
        }
    }
};
vm.runInNewContext(fs.readFileSync(path.join(root,'functions.js'),'utf8'),context);
const api=context.AdvancedEditor.api.tinymce;
api.newEditor('intro',{toolbar:0});
api.newEditor('body',{toolbar:2});
assert.equal(api.getContent('intro'),'<p>Intro</p>');
assert.equal(api.getContent('body'),'<p>Body</p>');
assert.ok(!configs.intro.toolbar.split(' ').includes('image'));
assert.ok(!configs.intro.file_picker_callback);
const protectedContent='[raw]<div>raw</div>[/raw]\n[code]x < y[/code]';
api.setContent('intro',protectedContent);
api.changeToolbar('intro','editor-toolbar3');
assert.equal(api.getContent('intro'),protectedContent);
assert.equal(api.getContent('body'),'<p>Body</p>');
assert.equal(configs.intro.license_key,'gpl');
assert.equal(configs.intro.base_url,'/editors/tinymce/vendor');
assert.equal(configs.intro.protect.length,3);
for (const regex of configs.intro.protect) assert.ok(regex.test(protectedContent) || regex.test('<pre>code</pre>'));
for (const plugin of configs.intro.plugins.split(' ')) assert.ok(fs.existsSync(path.join(root,'vendor/plugins',plugin,'plugin.min.js')),plugin);
console.log('TinyMCE adapter contract passed');
