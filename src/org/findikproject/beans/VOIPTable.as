package org.findikproject.beans
{
	[RemoteClass(alias="VOIPTable")]
    [Bindable]
	public class VOIPTable
	{
		public var id:int;
        public var name:String;
        public var localIp:String;
        public var localMask:String;
	}
}