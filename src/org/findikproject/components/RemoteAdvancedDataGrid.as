package org.findikproject.components
{
	import flash.events.MouseEvent;
	
	import mx.collections.ArrayCollection;
	import mx.collections.GroupingCollection;
	import mx.collections.IViewCursor;
	import mx.controls.AdvancedDataGrid;
	import mx.controls.Alert;
	import mx.controls.dataGridClasses.DataGridColumn;
	import mx.events.DataGridEvent;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.mxml.RemoteObject;
	
	public class RemoteAdvancedDataGrid extends AdvancedDataGrid
	{
		private var remoteObject:RemoteObject;
		private var selectedCategoryId:int = 0;
		private var searchKey:String = "";
		
		[Bindable]
		public var remoteSource:String;
		[Bindable]
		public var remoteDestination:String;
		[Bindable]
		public var dataCollection:ArrayCollection;
		[Bindable]
		public var groupingCollection:GroupingCollection;
		
		public function RemoteAdvancedDataGrid()
		{
			super();
			doubleClickEnabled = true;
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
			
			this.addEventListener(DataGridEvent.ITEM_EDIT_END,updateGrid);	
			
			this.allowMultipleSelection = false;
			
			this.getGridData();
		}
				
		private function faultListener(event:FaultEvent):void {
			Alert.show(event.fault.faultString);
	   		
	    }
	    	    
	    private function updateDataListener(event:ResultEvent):void {
	   		
	   	}
	   	private function insertDataListener(event:ResultEvent):void {
	   		
	   	} 
	   	private function deleteDataListener(event:ResultEvent):void {
	   		
   		}
   		private function getDataListener(event:ResultEvent):void {     
			dataCollection = new ArrayCollection(event.result as Array);	
			groupingCollection.refresh();
		}
		
		public function updateGrid(event:DataGridEvent):void {
	        if (event.dataField == "id") {
	             event.preventDefault();
	             return;
	        }
	        var dataGrid:DoubleClickDataGrid = event.target as DoubleClickDataGrid;
	        var col:DataGridColumn = dataGrid.columns[event.columnIndex];
	        var newValue:String = dataGrid.itemEditorInstance[col.editorDataField];
	        var val:Object = event.itemRenderer.data as Object	
	        if (newValue == val[event.dataField])
	           	return;
	        val[event.dataField] = newValue;
	        remoteObject.updateData(val);
	    }
	    public function getGridData():void {
	    	remoteObject.getData();
	    }
	    
	    public function remove(obj:Object):void {
	    	remoteObject.deleteData(obj);
			//remoteObject.getData();
	    }
	    
	    public function insert(arr:Array):void {
	    	var i:int = 0;
	    	for(;i < arr.length ;i++) {
	    		remoteObject.insertData(arr[i]);
	    	}
	    	remoteObject.getData();	    		
	    }
	    
	    public function search(searchKey:String):void {
	    	this.selectedCategoryId = selectedCategoryId;
	    	this.searchKey = searchKey;
	    	if(searchKey != null) {
		    	remoteObject.getData(searchKey);
	    	} 
	    }
	    
	    public function updateData(obj:Object):void {
	    	remoteObject.updateData(obj);
	    }
	    
	    public function getRemoteObject():RemoteObject {
	    	return remoteObject;
	    }
	    
	    override protected function mouseDoubleClickHandler(event:MouseEvent):void {
			super.mouseDoubleClickHandler(event);
			super.mouseDownHandler(event);
			super.mouseUpHandler(event);
		}

		override protected function mouseUpHandler(event:MouseEvent):void {
			var saved:String = editable;
			editable = "false";
			super.mouseUpHandler(event);
			editable = saved;
		}
	}
}