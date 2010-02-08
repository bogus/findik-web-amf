package org.findikproject.beans
{
	[RemoteClass(alias="VOTimeTable")]
    [Bindable]
	public class VOTimeTable
	{
		public var id:int;
        public var name:String;
        public var startTime:String;
        public var endTime:String;
        public var dayOfWeek:int;
	}
}