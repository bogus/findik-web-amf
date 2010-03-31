package org.findikproject.beans
{
	[RemoteClass(alias="VOBTKDbUpdate")]
    [Bindable]
	public class VOBTKDbUpdate
	{
		public var id:int;
        public var updateId:String;
        private var _updateDate:String;
        public var newRecordCount:Number;
        public var deletedRecordCount:Number;
        
        public function get updateDate():String
        {
            return _updateDate;
        }
   
        public function set updateDate(value:*):void
        {
    		var time:Number = value;
    		var date:Date = new Date(time); 
            _updateDate = date.toUTCString();
        } 
	}
}