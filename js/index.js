//  function getallmeeting()
//   {
//      // API for get requests 
//         let fetchRes = fetch( 
// "http://localhost/sample-app-web/CDN/getallmeeting.php"); 
  
//         // fetchRes is the promise to resolve 
//         // it by using.then() method 
//         fetchRes.then(res => 
//             res.json()).then(d => { 
//                 console.log(d) 
//             }) 
//   }
window.addEventListener( 'DOMContentLoaded', function ( event )
{
  console.log('DOM fully loaded and parsed');
//  websdkready();
//  getallmeeting();
});
  
function websdkready(meeting_id,passcode,role,name) {
  var testTool = window.testTool;
  if (testTool.isMobileDevice()) {
    vConsole = new VConsole();
  }
  console.log("checkSystemRequirements");
  console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

  // it's option if you want to change the WebSDK dependency link resources. setZoomJSLib must be run at first
  // if (!china) ZoomMtg.setZoomJSLib('https://source.zoom.us/1.9.0/lib', '/av'); // CDN version default
  // else ZoomMtg.setZoomJSLib('https://jssdk.zoomus.cn/1.9.0/lib', '/av'); // china cdn option
  // ZoomMtg.setZoomJSLib('http://localhost:9999/node_modules/@zoomus/websdk/dist/lib', '/av'); // Local version default, Angular Project change to use cdn version
  ZoomMtg.preLoadWasm(); // pre download wasm file to save time.

  var API_KEY = "I9lhxanzQ7yO6BP-fA7rFw";

  /**
   * NEVER PUT YOUR ACTUAL API SECRET IN CLIENT SIDE CODE, THIS IS JUST FOR QUICK PROTOTYPING
   * The below generateSignature should be done server side as not to expose your api secret in public
   * You can find an eaxmple in here: https://marketplace.zoom.us/docs/sdk/native-sdks/web/essential/signature
   */
  var API_SECRET = "c9suCpAbpEBQWtMnxTmhwIFp5HGh0ZNol1uU";

  
      console.log("key:-"+testTool.getMeetingConfig(meeting_id,passcode,role,name));
      var meetingConfig = testTool.getMeetingConfig(meeting_id,passcode,role,name);
      if (!meetingConfig.mn || !meetingConfig.name) {
        alert("Meeting number or username is empty");
        return false;
      }

      
      testTool.setCookie("meeting_number", meetingConfig.mn);
      testTool.setCookie("meeting_pwd", meetingConfig.pwd);

      var signature = ZoomMtg.generateSignature({
        meetingNumber: meetingConfig.mn,
        apiKey: API_KEY,
        apiSecret: API_SECRET,
        role: meetingConfig.role,
        success: function (res) {
          console.log(res.result);
          meetingConfig.signature = res.result;
          meetingConfig.apiKey = API_KEY;
          var joinUrl = "http://localhost/sample-app-web/CDN/meeting.html?" + testTool.serialize(meetingConfig);
          console.log( joinUrl );
         
          window.open(joinUrl, "theFrame");
                 },
      });
  

  function copyToClipboard(elementId) {
    var aux = document.createElement("input");
    aux.setAttribute("value", document.getElementById(elementId).getAttribute('link'));
    document.body.appendChild(aux);  
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
  }
    
  // click copy jon link button
  window.copyJoinLink = function (element) {
    var meetingConfig = testTool.getMeetingConfig();
    if (!meetingConfig.mn || !meetingConfig.name) {
      alert("Meeting number or username is empty");
      return false;
    }
    var signature = ZoomMtg.generateSignature({
      meetingNumber: meetingConfig.mn,
      apiKey: API_KEY,
      apiSecret: API_SECRET,
      role: 1,
      success: function (res) {
        console.log(res.result);
        meetingConfig.signature = res.result;
        meetingConfig.apiKey = API_KEY;
        var joinUrl =
          testTool.getCurrentDomain() +
          "/meeting.html?" +
          testTool.serialize(meetingConfig);
        document.getElementById('copy_link_value').setAttribute('link', joinUrl);
        copyToClipboard('copy_link_value');
        
      },
    } );
    
  };

 
  

 
  
// function generateSignature(apiKey, apiSecret, meetingNumber, role) {

//   // Prevent time sync issue between client signature generation and zoom 
//   const timestamp = new Date().getTime() - 30000
//   const msg = Buffer.from(apiKey + meetingNumber + timestamp + role).toString('base64')
//   const hash = crypto.createHmac('sha256', apiSecret).update(msg).digest('base64')
//   const signature = Buffer.from(`${apiKey}.${meetingNumber}.${timestamp}.${role}.${hash}`).toString('base64')

//   return signature
// }

// // pass in your Zoom JWT API Key, Zoom JWT API Secret, Zoom Meeting Number, and 0 to join meeting or webinar or 1 to start meeting
// console.log(generateSignature(process.env.API_KEY, process.env.API_SECRET, meetingConfig.mn, 0))
}
