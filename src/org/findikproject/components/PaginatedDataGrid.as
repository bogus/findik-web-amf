package org.findikproject.components
{
	public class PaginatedDataGrid extends DoubleClickDataGrid
	{
		[Bindable]
		private var currentPage:int = 0;
		[Bindable]
		private var totalPages:int=0;
		[Bindable] 
		private var pageElementCount:int=0;
		[Bindable] 
		private var isFirstPage:Boolean = true;
		[Bindable] 
		private var isLastPage:Boolean = false;
		
		
		public function PaginatedDataGrid()
		{
			super();
		}
		
		[Bindable]
        public function get pageElementCount():int {
            return pageElementCount;
        }
        
        public function set pageElementCount(value:int):void {
            pageElementCount = value;
        }

		[Bindable]
        public function get currentPage():int {
            return currentPage;
        }
        
        public function set currentPage(value:int):void {
            currentPage = value;
        }
		
		[Bindable]
        public function get totalPages():int {
            return totalPages;
        }
        
        public function set totalPages(value:int):void {
            totalPages = value;
        }
	}
}