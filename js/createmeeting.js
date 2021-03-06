const meetConfig = {
	apiKey: '3239845720934223459',
	meetingNumber: '123456789',
	leaveUrl: 'https://yoursite.com/meetingEnd',
	userName: 'Firstname Lastname',
	passWord: 'password',
	role: 1 // 1 for host
};
import { ZoomMtg } from '@zoomus/websdk'

// prepare required files
ZoomMtg.preLoadWasm();
ZoomMtg.prepareJssdk();

getSignature(meetConfig) {
	// make a request for a signature
	fetch(`${YOUR_SIGNATURE_ENDPOINT}`, {
			method: 'POST',
			body: JSON.stringify({ meetingData: meetConfig })
		})
		.then(result => result.text())
		.then(response => {
			// call the init method with meeting settings
			ZoomMtg.init({
				leaveUrl: meetConfig.leaveUrl,
				isSupportAV: true,
				// on success, call the join method
				success: function() {	
					ZoomMtg.join({
						// pass your signature response in the join method
						signature: response,
						apiKey: meetConfig.apiKey,
						meetingNumber: meetConfig.meetingNumber,
						userName: meetConfig.userName,
						passWord: meetConfig.passWord 
						error(res) { 
							console.log(res) 
						}
					})		
				}
			})
	}
}
