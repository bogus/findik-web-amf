package org.findikproject.beans
{
	[RemoteClass(alias="VOBTKTimestampHistory")]
    [Bindable]
	public class VOBTKTimestampHistory
	{
		public var id:int;
        public var startDate:Date;
        public var endDate:Date;
        public var logSize:Number;
        public var status:Number;
	}
}