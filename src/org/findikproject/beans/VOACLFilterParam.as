package org.findikproject.beans
{
	[RemoteClass(alias="VOACLFilterParam")]
    [Bindable]
	public class VOACLFilterParam
	{
		public var id:int;
        public var ruleId:int;
        public var param:int;
        public var name:String;
        public var filterKey:String;
	}
}