FB.init({ 
	appId:'127244637430412', cookie:true, 
    status:true, xfbml:true 
});

function FacebookInviteFriends()
{
	FB.ui({ method: 'apprequests', 
	message: 'Critique les marques et partage tes expériences consommateurs !'});
}