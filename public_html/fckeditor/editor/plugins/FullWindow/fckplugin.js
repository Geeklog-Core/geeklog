// Register the related command.

var FCKFullWindow = function(name) 
{ 
this.Name = name; 
}


FCKFullWindow.prototype.Execute = function() 
{ 
	var oDialogInfo = new Object() ;
	oDialogInfo.Editor = window;
	FCKDialog.Show(oDialogInfo, 'FullScreen', FCKConfig.PluginsPath + 'FullWindow/fullwindow.html?name=' + FCK.Name,
                800, 780, window, true);
    
} 
 
// manage the plugins' button behavior 
FCKFullWindow.prototype.GetState = function() 
{ 
  return FCK_TRISTATE_OFF; 
  // default behavior, sometimes you wish to have some kind of if statement here 
} 

FCKCommands.RegisterCommand( 'FullWindow', new FCKFullWindow('FullWindow'));

// Create the "Plaholder" toolbar button.
var oFullWindowItem = new FCKToolbarButton( "FullWindow", FCKLang.FullWindow ) ;
oFullWindowItem.IconPath = FCKConfig.PluginsPath + 'FullWindow/fullwindow.gif' ;
FCKToolbarItems.RegisterItem( 'FullWindow', oFullWindowItem ) ;


