package org.findikproject.util
{
	import flash.events.Event;

	public class RemoteDataObjectEvent extends Event
	{
		public static const DATA_RECEIVED:String = "dataReceived";

		
		public function RemoteDataObjectEvent(type:String)
		{
			super(type);
		}
		
		override public function clone():Event {
            return new RemoteDataObjectEvent(type);
        }

	}
}