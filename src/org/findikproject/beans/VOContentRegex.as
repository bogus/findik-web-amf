package org.findikproject.beans
{
	[RemoteClass(alias="VOContentRegex")]
    [Bindable]
	public class VOContentRegex
	{
		public var id:int;
        public var regex:String;
        public var catId:int;
	}
}