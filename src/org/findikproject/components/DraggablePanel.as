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
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	import mx.containers.Panel;
	import mx.controls.Image;
	import mx.effects.Resize;

	public class DraggablePanel extends Panel
	{
		private var minMaxBtn:Image = new Image();
        private var effResize:Resize = new Resize();
        private var previousHeight:int = 30;
        
        [Embed(source="/assets/images/minimize.png")]
		private var minimizeIcon:Class;

		[Embed(source="/assets/images/maximize.png")]
		private var maximizeIcon:Class;
		
		public function DraggablePanel()
		{
			super();
			minMaxBtn.buttonMode = true;
			minMaxBtn.useHandCursor = true;
			minMaxBtn.source = minimizeIcon;
			minMaxBtn.height = 16;
			minMaxBtn.width = 16;
			minMaxBtn.addEventListener(MouseEvent.CLICK, minimisePanel);
		}

		private function handleDown(e:Event):void{
			this.startDrag()
		}
		private function handleUp(e:Event):void{
			this.stopDrag()
		}
		override protected function createChildren():void{
			super.createChildren();
			super.titleBar.addEventListener(MouseEvent.MOUSE_DOWN,handleDown);
			super.titleBar.addEventListener(MouseEvent.MOUSE_UP,handleUp);
			super.titleBar.addChild(minMaxBtn);
		}

        private function minimisePanel(e:MouseEvent):void{
            effResize.stop();
            minMaxBtn.removeEventListener(MouseEvent.CLICK, minimisePanel);
            minMaxBtn.addEventListener(MouseEvent.CLICK, maxmisePanel);
            minMaxBtn.source = maximizeIcon;
            effResize.heightFrom = height;
            effResize.heightTo = previousHeight;
            previousHeight = height;
            effResize.play([this]);
        }

        private function maxmisePanel(e:MouseEvent):void{
            effResize.stop();
            minMaxBtn.removeEventListener(MouseEvent.CLICK, maxmisePanel);
            minMaxBtn.addEventListener(MouseEvent.CLICK, minimisePanel);
            minMaxBtn.source = minimizeIcon;
            effResize.heightFrom = height;
            effResize.heightTo = previousHeight;
            previousHeight = height;
            effResize.play([this]);
        }

        override protected function updateDisplayList(w:Number, h:Number):void{
            super.updateDisplayList(w,h);
            minMaxBtn.x = super.titleBar.width - 28;
            minMaxBtn.y = 7;
            minMaxBtn.width = 16;
            minMaxBtn.height = 16;
        }

	}
}