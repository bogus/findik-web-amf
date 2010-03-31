package org.findikproject.beans
{
	[RemoteClass(alias="VOBTKGeneralInfo")]
    [Bindable]
	public class VOBTKGeneralInfo
	{
		public var updateName:String;
        private var _updateDate:Date;
        public var currentClient:Number;
        
        public function get updateDate():Date
        {
            return _updateDate;
        }
   
        public function set updateDate(value:*):void
        {
    		var time:Number = value;
            _updateDate = new Date(time);
        } 
	}	
	
}