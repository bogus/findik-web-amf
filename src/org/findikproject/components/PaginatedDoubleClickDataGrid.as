/*
  Copyright (C) 2009 Burak Oguz (barfan) <findikmail@gmail.com>

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
*/
/*
Search incelenmeli 
*/

package org.findikproject.components
{
	import mx.controls.Alert;
	import mx.controls.Image;
	import mx.controls.Label;
	import mx.controls.dataGridClasses.DataGridColumn;
	import mx.events.DataGridEvent;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.mxml.RemoteObject;
	
	public class PaginatedDoubleClickDataGrid extends DoubleClickDataGrid
	{
		private var remoteObject:RemoteObject;
		private var selectedCategoryId:int = 0;
		private var searchKey:String = "";
		
		[Bindable]
		public var remoteSource:String;
		[Bindable]
		public var remoteDestination:String;
		[Bindable]
		public var statusLabel:Label;
		[Bindable]
		public var statusImage:Image;
		[Bindable]
		public var paginationCanvas:PaginationCanvas = null;
		
		public function PaginatedDoubleClickDataGrid()
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
			remoteObject.updateData.addEventListener(ResultEvent.RESULT,updateDataListener);
			remoteObject.deleteData.addEventListener(ResultEvent.RESULT,deleteDataListener);
			remoteObject.getSearchCount.addEventListener(ResultEvent.RESULT,getSearchCountListener);
			
			this.addEventListener(DataGridEvent.ITEM_EDIT_END,updateGrid);
			
			this.allowMultipleSelection = true;	
		}
		
		override public function get listRendererArray():Array {
			return listItems;
		}
				
		private function faultListener(event:FaultEvent):void {
	   		statusImage.load('assets/images/icons/16x16/no.png');
	   		statusLabel.text = resourceManager.getString('resources','error');
	    }	    
	    private function updateDataListener(event:ResultEvent):void {
	   		statusImage.load('assets/images/icons/16x16/ok.png');
	        statusLabel.text = resourceManager.getString('resources','update.successful');
	   	}
	   	private function insertDataListener(event:ResultEvent):void {
	   		statusImage.load('assets/images/icons/16x16/ok.png');
	   		statusLabel.text = resourceManager.getString('resources','insert.successful');
	   	} 
	   	private function deleteDataListener(event:ResultEvent):void {
	   		statusImage.load('assets/images/icons/16x16/ok.png');
	   		statusLabel.text = resourceManager.getString('resources','delete.successful');
   		}
   		private function getDataListener(event:ResultEvent):void {     
			dataProvider = event.result as Array;
			if(paginationCanvas != null) 
				paginationCanvas.setPagination();		
			statusImage.load('assets/images/icons/16x16/ok.png');
	   		statusLabel.text = resourceManager.getString('resources','content.selectionsuccessful');
		}
		private function getSearchCountListener(event:ResultEvent):void {
			if(paginationCanvas != null)      
				paginationCanvas.resetPagination(event.result as int);
			statusImage.load('assets/images/icons/16x16/ok.png');
	   		statusLabel.text = resourceManager.getString('resources','content.selectionsuccessful');
		}
   		public function changeSelectedCategory(selectedCategoryId:int, totalElements:int):void {
   			this.selectedCategoryId = selectedCategoryId;
   			searchKey = "";
   			if(paginationCanvas != null) {
   				remoteObject.getData(selectedCategoryId, 0, paginationCanvas.pageElementCount);
   				paginationCanvas.resetPagination(totalElements);
   			} else {
   				remoteObject.getData(selectedCategoryId);
   			}
   		}   
		
		private function updateGrid(event:DataGridEvent):void {
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
	    
	    public function remove(arr:Array):void {
	    	var i:int = 0;
	    	for(;i < arr.length ;i++) {
	    		remoteObject.deleteData(arr[i]);
	    	}
	    	if(paginationCanvas != null) {
		    	paginationCanvas.totalElement -= arr.length;
		        remoteObject.getData(selectedCategoryId, (paginationCanvas.currentPage-1)*paginationCanvas.pageElementCount,
						paginationCanvas.pageElementCount);
				paginationCanvas.changeTotalPage(paginationCanvas.totalElement);
	    	} else {
	    		remoteObject.getData(selectedCategoryId);
	    	}
	    }
	    
	    public function insert(arr:Array):void {
	    	var i:int = 0;
	    	for(;i < arr.length ;i++) {
	    		remoteObject.insertData(arr[i]);
	    	}
	    	if(paginationCanvas != null) {
		    	paginationCanvas.totalElement += arr.length;
		    	remoteObject.getData(selectedCategoryId, (paginationCanvas.currentPage-1)*paginationCanvas.pageElementCount,
						paginationCanvas.pageElementCount);
				paginationCanvas.changeTotalPage(paginationCanvas.totalElement);
	    	} else {
	    		remoteObject.getData(selectedCategoryId);
	    	}
	    }
	    
	    public function search(searchKey:String, selectedCategoryId:int):void {
	    	this.selectedCategoryId = selectedCategoryId;
	    	this.searchKey = searchKey;
	    	if(searchKey != null) {
		    	remoteObject.getSearchCount(searchKey, selectedCategoryId);
		    	if(paginationCanvas != null)
					remoteObject.getData(selectedCategoryId, 0, paginationCanvas.pageElementCount, searchKey);
	    	} else {
	    		if(paginationCanvas != null)
	    			paginationCanvas.resetPagination(0);
	    		dataProvider = null;
	    	}
	    }
	    
	    public function getPaginatedData(paginationCanvas:PaginationCanvas): void {
			remoteObject.getData(selectedCategoryId, (paginationCanvas.currentPage-1)*paginationCanvas.pageElementCount,
				paginationCanvas.pageElementCount, searchKey);
		}
		
	} 	
}