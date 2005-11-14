// Register the related command.
var FCKCloseWindow = function(name)
{
	this.Name = name;
}


FCKCloseWindow.prototype.Execute = function()
{
	parent.window.close();
}

// manage the plugins' button behavior
FCKCloseWindow.prototype.GetState = function()
{
	return FCK_TRISTATE_OFF;
	// default behavior, sometimes you wish to have some kind of if statement here
}


FCKCommands.RegisterCommand( 'My_CloseWindow', new FCKCloseWindow('CloseWindow'));


// Create the "Plaholder" toolbar button.
var oCloseWindowItem = new FCKToolbarButton( 'My_CloseWindow', FCKLang.CloseWindow ) ; //opject_name, button_alt_text
oCloseWindowItem.IconPath = FCKConfig.PluginsPath + 'CloseWindow/closewindow.gif' ;
FCKToolbarItems.RegisterItem( 'CloseWindow', oCloseWindowItem ) ;


