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
package org.findikproject.beans
{
	import mx.controls.Alert;
	
	[RemoteClass(alias="VOTimeline")]
    [Bindable]
	public class VOTimeline
	{
		public var id:int;
        private var _startDate:Date;
        private var _endDate:Date;
        public var status:Number;
        public var label:String;
        
        public function get startDate():Date
        {
            return _startDate;
        }
   
        public function set startDate(value:*):void
        {
    		var time:Number = value;
            _startDate = new Date(time);
        } 
        
        public function get endDate():Date
        {
            return _endDate;
        }
   
        public function set endDate(value:*):void
        {
    		var time:Number = value;
            _endDate = new Date(time);
        } 
	}
}