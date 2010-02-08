package org.findikproject.beans
{
	[RemoteClass(alias="VOACLRule")]
    [Bindable]
	public class VOACLRule
	{
		public var id:int;
        public var rank:int;
        public var deny:int;
        public var name:String;
        public var desc:String;
        public var av:int;
	}
}