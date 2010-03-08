package org.findikproject.components
{
	import org.findikproject.util.RemoteDataObjectEvent;
	
	import mx.controls.Alert;
	import mx.controls.Image;
	import mx.controls.Label;
	import mx.resources.ResourceManager;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.mxml.RemoteObject;
	
	[Event(name="dataReceived", type="org.findikproject.util.RemoteDataObjectEvent")]
	public class RemoteDataObject
	{
		private var remoteObject:RemoteObject;
		private var remoteDestination:String = "zend";
		private var remoteSource:String;		
		private var statusLabel:Label = null;
		private var statusImage:Image = null;
		
		[Bindable]
		public var remoteData:Object = null;
		
		public function RemoteDataObject(remoteSource:String, statusLabel:Label, statusImage:Image)
		{
			super();
			this.remoteSource = remoteSource;
			this.statusLabel = statusLabel;
			this.statusImage = statusImage;
		}
		
		public function init():void {
		
			remoteObject = new RemoteObject(remoteDestination);
			remoteObject.source = remoteSource;
			remoteObject.showBusyCursor = true;
			remoteObject.addEventListener(FaultEvent.FAULT,faultListener);
			remoteObject.getData.addEventListener(ResultEvent.RESULT,getDataListener);
			remoteObject.insertData.addEventListener(ResultEvent.RESULT,insertDataListener);
			remoteObject.updateData.addEventListener(ResultEvent.RESULT,updateDataListener);
			remoteObject.deleteData.addEventListener(ResultEvent.RESULT,deleteDataListener);
		
			this.getObject();
		}
				
		private function faultListener(event:FaultEvent):void {
			Alert.show(event.fault.message);
			if(statusImage != null && statusLabel != null) {
		   		statusImage.load('assets/images/icons/16x16/no.png');
		   		statusLabel.text = ResourceManager.getInstance().getString('resources','error');
		 	}
	    }
	    	    
	    private function updateDataListener(event:ResultEvent):void {
	    	if(statusImage != null && statusLabel != null) {
		   		statusImage.load('assets/images/icons/16x16/ok.png');
		        statusLabel.text = ResourceManager.getInstance().getString('resources','update.successful');
		    }
	   	}
	   	private function insertDataListener(event:ResultEvent):void {
	   		if(statusImage != null && statusLabel != null) {
		   		statusImage.load('assets/images/icons/16x16/ok.png');
		   		statusLabel.text = ResourceManager.getInstance().getString('resources','insert.successful');
		   	}
	   	} 
	   	private function deleteDataListener(event:ResultEvent):void {
	   		if(statusImage != null && statusLabel != null) {
		   		statusImage.load('assets/images/icons/16x16/ok.png');
		   		statusLabel.text = ResourceManager.getInstance().getString('resources','delete.successful');
		   	}
   		}
   		private function getDataListener(event:ResultEvent):void {     
			remoteData = event.result as Array;
			var eventObj:RemoteDataObjectEvent = new RemoteDataObjectEvent(RemoteDataObjectEvent.DATA_RECEIVED);
			dispatchEvent(eventObj);
			if(statusImage != null && statusLabel != null) {	
				statusImage.load('assets/images/icons/16x16/ok.png');
		   		statusLabel.text = ResourceManager.getInstance().getString('resources','content.selectionsuccessful');
		 	}
		}
		
		public function updateObject(obj:Object):void {
	        remoteObject.updateData(obj);
	    }
	    public function getObject():void {
	    	remoteObject.getData();
	    }
	    
	    public function remove(obj:Object):void {
	    	remoteObject.deleteData(obj);
	    	remoteObject.getData();
	    }
	    
	    public function insert(obj:Object):void {
	    	remoteObject.insertData(obj);
	    	remoteObject.getData();	    		
	    }
	    
	    public function getRemoteObject():RemoteObject {
	    	return remoteObject;
	    }
	}
}