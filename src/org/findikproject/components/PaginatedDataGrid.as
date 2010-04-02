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