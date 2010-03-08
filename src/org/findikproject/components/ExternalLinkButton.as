package org.findikproject.components
{
  import flash.events.MouseEvent;
  import flash.net.URLRequest;
  import flash.net.navigateToURL;
  
  import mx.controls.LinkButton;

  public class ExternalLinkButton extends LinkButton
  {
    public var url:String = "";
    
    public function ExternalLinkButton()
    {
      super();
      addEventListener(MouseEvent.CLICK, followLink);
    }
    
    private function followLink(event:MouseEvent):void
    {
      if(url == "")
        return;
      var urlReq:URLRequest = new URLRequest(url);
      navigateToURL(urlReq);  
    }
  }
}