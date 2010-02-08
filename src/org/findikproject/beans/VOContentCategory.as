package org.findikproject.beans
{
	[RemoteClass(alias="VOContentCategory")]
    [Bindable]
	public class VOContentCategory
	{
		public var id:int;
        public var name:String;
        public var domainCount:int;
        public var urlCount:int;
        public var regexCount:int;
	}
}