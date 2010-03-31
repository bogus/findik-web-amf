package org.findikproject.components
{
	import flash.events.KeyboardEvent;
	
	import mx.collections.ArrayCollection;
	import mx.collections.IViewCursor;
	import mx.controls.Alert;
	import mx.core.IUIComponent;
	import mx.events.DragEvent;
	import mx.managers.DragManager;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.mxml.RemoteObject;
	
	import org.findikproject.beans.VOACLFilterParam;
	
	public class ACLInnerDataGrid extends DoubleClickDataGrid
	{
		private var remoteObject:RemoteObject;
		
		[Bindable]
		public var remoteSource:String;
		[Bindable]
		public var remoteDestination:String;
		[Bindable]
		private var _ruleId:int;
		[Bindable]
		public var filterGroupName:String;
		[Bindable]
		public var dragInitiatorId:String;
		
		private var _data:Object;
		
		public function ACLInnerDataGrid()
		{
			super();
		}
		
		public function init():void {
			remoteObject = new RemoteObject(remoteDestination);
			remoteObject.source = remoteSource;
			remoteObject.showBusyCursor = true;
			remoteObject.addEventListener(FaultEvent.FAULT,faultListener);
			remoteObject.getData.addEventListener(ResultEvent.RESULT,getDataListener);
			remoteObject.insertData.addEventListener(ResultEvent.RESULT,insertDataListener);
			remoteObject.deleteData.addEventListener(ResultEvent.RESULT,deleteDataListener);
			
			this.editable = false;
			this.allowMultipleSelection = true;
			
			this.addEventListener(DragEvent.DRAG_DROP, insertDragDropListener);
			this.addEventListener(DragEvent.DRAG_ENTER, insertDragEnterListener);
			this.addEventListener(KeyboardEvent.KEY_UP, keyHandler);
			this.getGridData();
		}
		
		public function set ruleId(value:int):void {
			_ruleId = value;
			this.getGridData();
		}
		
		public function get ruleId():int {
			return _ruleId;
		}
		
		override public function get listRendererArray():Array {
			return listItems;
		}
				
		private function faultListener(event:FaultEvent):void {
	   		Alert.show(event.fault.message);
	    }
	   	private function insertDataListener(event:ResultEvent):void {
	   		
	   	} 
	   	private function deleteDataListener(event:ResultEvent):void {
	   		
   		}
   		private function getDataListener(event:ResultEvent):void {     
			dataProvider = event.result as Array;	
		}
		
		private function insertDragDropListener(event:DragEvent):void {
			if (event.dragSource.hasFormat("items"))
	    	{		    	
		    	var itemsArray:Array = event.dragSource.dataForFormat("items") as Array;
		    	var arrList:ArrayCollection = new ArrayCollection();
				var i:int = 0;
	    		for(;i < itemsArray.length;i++) {
	    			var cursor:IViewCursor = dataProvider.createCursor();
	    			var isRepetition:Boolean = false; 
	    			while(!cursor.afterLast) {
	    				if(cursor.current.param == itemsArray[i].id) {
	    					isRepetition = true;
	    					break;
	    				}
	    				cursor.moveNext();
	    			}
	    			if(!isRepetition) {
		    			var val:VOACLFilterParam = new VOACLFilterParam();
		    			val.id = 0;
		    			val.filterKey = filterGroupName;
		    			val.ruleId = _ruleId;
		    			val.param = itemsArray[i].id;
		    			val.name = itemsArray[i].name;
		    			arrList.addItem(val);
	    			}
	    		}
	    		
	    		insert(arrList.toArray());
	    	}
		}
		
		private function insertDragEnterListener(event:DragEvent):void {
			var obj:IUIComponent = IUIComponent(event.currentTarget);
			if((event.dragInitiator as RemoteDoubleClickDataGrid).id == dragInitiatorId)
	    		DragManager.acceptDragDrop(obj);
		} 
		
		public function remove(arr:Array):void {
	    	var i:int = 0;
	    	var j:int = 0;
	    	for(;i < arr.length ;i++) {
	    		remoteObject.deleteData(arr[i],_ruleId);
	    		var cursor:IViewCursor = dataProvider.createCursor();
	    		for(j = 0; !cursor.afterLast; j++) {
	    			if(cursor.current.id == arr[i].id) {
	    				dataProvider.removeItemAt(j);
	    			}
	    			cursor.moveNext();
	    		}
	    	}
	    }
	    
	    public function insert(arr:Array):void {
	    	var i:int = 0;
	    	for(;i < arr.length ;i++) {
	    		remoteObject.insertData(arr[i]);
	    	}
	    	remoteObject.getData(filterGroupName,_ruleId);	    		
	    }
	    
	    public function getGridData():void {
	    	remoteObject.getData(filterGroupName,_ruleId);
	    }
		
		private function keyHandler(event:KeyboardEvent):void {
			Alert.show(event.keyCode.toString());
            if(event.keyCode == 46) {
            	this.remove(this.selectedItems as Array);
            	for(var i:int = 0; i < selectedIndices.length; i++) {
            		(this.dataProvider as ArrayCollection).removeItemAt(selectedIndices[i]);
            	}
            }
        }
	}
}