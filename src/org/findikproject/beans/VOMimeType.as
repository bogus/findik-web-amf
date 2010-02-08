package org.findikproject.beans
{
	[RemoteClass(alias="VOMimeType")]
    [Bindable]
	public class VOMimeType
	{
		public var id:int;
        public var fileExt:String;
        public var mimeType:String;
	}
}