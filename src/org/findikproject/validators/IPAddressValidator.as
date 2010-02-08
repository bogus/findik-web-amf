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
package org.findikproject.validators
{
	import mx.validators.ValidationResult;
	import mx.validators.Validator;
	
	public class IPAddressValidator extends Validator {
	
		public function IPAddressValidator() {
			super();
		}
	
		override protected function doValidation(value:Object):Array {
		
			var ValidatorResults:Array = new Array();
			ValidatorResults = super.doValidation(value);
			
			if (ValidatorResults.length > 0)
				return ValidatorResults;
			
			if (String(value).length == 0)
				return ValidatorResults;
			
			var RegPattern:RegExp = /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;
			
			var a:Array = RegPattern.exec(String(value));
			
			if (a == null){
				ValidatorResults.push(new ValidationResult(true, null, "IPAdres Hatası","IP Adresi Girmelisiniz"));
				return ValidatorResults;
			}
			return ValidatorResults;
		}
	}
}