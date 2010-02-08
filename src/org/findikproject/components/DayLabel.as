package org.findikproject.components
{
	import mx.collections.ArrayCollection;
	import mx.controls.Label;
	import mx.controls.listClasses.*;
    
	public class DayLabel extends Label
	{
		public function DayLabel()
		{
			super();
		}
		
		override protected function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void {
            super.updateDisplayList(unscaledWidth, unscaledHeight);
            var days:int = 0;
            var i:int = 0;
            var list:ArrayCollection = new ArrayCollection();
            var finalDayStr:String = "";
            if(data.atime != null) {
            	var atime:String = data.atime;
            	var tooltipArr:Array = atime.split("/");
            	days = parseInt(tooltipArr[2]);
	            
	            if((days & 2) == 2)
	            	list.addItem("Mon");
	            if((days & 4) == 4)
	            	list.addItem("Tue");
	            if((days & 8) == 8)
	            	list.addItem("Wed");
	            if((days & 16) == 16)
	            	list.addItem("Thu");
	            if((days & 32) == 32)
	            	list.addItem("Fri");
	            if((days & 64) == 64)
	            	list.addItem("Sat");
	            if((days & 128) == 128)
	            	list.addItem("Sun");
	            
	            for(i = 0; i < list.length; i++) {
	            	finalDayStr += list.getItemAt(i);
	            	if(i + 1 < list.length)
	            		finalDayStr += ",";	
	            }
	            	
				this.text = data.name;
				this.toolTip = tooltipArr[0] + " / " + tooltipArr[1] + " / " + finalDayStr; 
            } else {
	            days = data.days;
	            
	            
	            if((days & 2) == 2)
	            	list.addItem("Mon");
	            if((days & 4) == 4)
	            	list.addItem("Tue");
	            if((days & 8) == 8)
	            	list.addItem("Wed");
	            if((days & 16) == 16)
	            	list.addItem("Thu");
	            if((days & 32) == 32)
	            	list.addItem("Fri");
	            if((days & 64) == 64)
	            	list.addItem("Sat");
	            if((days & 128) == 128)
	            	list.addItem("Sun");
	            
	            for(i = 0; i < list.length; i++) {
	            	finalDayStr += list.getItemAt(i);
	            	if(i + 1 < list.length)
	            		finalDayStr += ",";	
	            }
	            	
				this.text = finalDayStr;
            }
        }

		
	}
}