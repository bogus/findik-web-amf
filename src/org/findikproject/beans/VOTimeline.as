package org.findikproject.beans
{
	import mx.controls.Alert;
	
	[RemoteClass(alias="VOTimeline")]
    [Bindable]
	public class VOTimeline
	{
		public var id:int;
        private var _startDate:Date;
        private var _endDate:Date;
        public var status:Number;
        public var label:String;
        
        public function get startDate():Date
        {
            return _startDate;
        }
   
        public function set startDate(value:*):void
        {
    		var time:Number = value;
            _startDate = new Date(time);
        } 
        
        public function get endDate():Date
        {
            return _endDate;
        }
   
        public function set endDate(value:*):void
        {
    		var time:Number = value;
            _endDate = new Date(time);
        } 
	}
}