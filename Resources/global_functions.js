function resetPostPin()
{
	if($("#post_content").val() == "Was gibt's neues?")
		$("#post_content").val("");
}

function checkPostPin()
{
    if($("#post_content").val() == "")
    {
        $("#post_content").val("Was gibt's neues?");
    }
}

function resetSearch()
{
	if($("#search_word").val() == "Suchen...")
		$("#search_word").val("");
}

function checkSearch()
{
    if($("#search_word").val() == "")
    {
        $("#search_word").val("Suchen...");
    }
}

function showLikedList(pin)
{
	$.getJSON("?page=Board&action=WhoLiked&pin=" + pin, function(data) {
		$("#who_liked").css({
			'display': 'block'
		});
		$(".popup__overlay").css({
			display: 'block'
		});
		$("#popup_header_liked").css({
			display: 'block'
		});
		$("#popup_header_disliked").css({
			display: 'none'
		});
		
		var list = "";
		
		$.each(data, function(id, user) {
			list += '<div class="who_liked_"><div class="photo_small"><img alt="Profilbild" src="Resources/ProfilePics/' + user.picture + '.png" width="40" height="40"></div><div class="name"><a href="?page=Board&user=' + id + '">' + user.firstname + ' ' + user.lastname + '</a></div></div>';
		});
		
		$("#who_liked_list").html(list);
	});
}

function setFriend(who, elem)
{
	$.getJSON("?page=Board&action=SetFriend&who=" + who, function(data) {
		switch(data.status)
		{
			case 0:
			$(elem).text("Freundschaft zurückziehen");
			break;
			
			case 1:
			$(elem).text("Als Freund hinzufügen");
			break;
			
			case 2:
			$(elem).text("Freundschaftsanfrage zurückziehen");
			break;
		}
	});
}

function showDislikedList(pin)
{
	$.getJSON("?page=Board&action=WhoDisliked&pin=" + pin, function(data) {
		$("#who_liked").css({
			'display' : 'block'
		});
		$(".popup__overlay").css({
			display: 'block'
		});
		$("#popup_header_disliked").css({
			display: 'block'
		});
		$("#popup_header_liked").css({
			display: 'none'
		});
		
		var list = "";
		
		$.each(data, function(id, user) {
			list += '<div class="who_liked_"><div class="photo_small"><img alt="Profilbild" src="Resources/ProfilePics/' + user.picture + '.png" width="40" height="40"></div><div class="name"><a href="?page=Board&user=' + id + '">' + user.firstname + ' ' + user.lastname + '</a></div></div>';
		});
		
		$("#who_liked_list").html(list);
	});
}

function closePopup() {
    $("#who_liked").css({
        'display' : 'none'
    });
    $(".popup__overlay").css({
        display: 'none'
    });
    $("#popup_header_liked").css({
        display: 'none'
    });
    $("#popup_header_disliked").css({
        display: 'none'
    });
}

function like(pin)
{
	$.getJSON("?page=Board&action=Like&pin=" + pin, function(data) {
		loadPin(pin, data);
	});
}

function dislike(pin)
{
	$.getJSON("?page=Board&action=Dislike&pin=" + pin, function(data) {
		loadPin(pin, data);
	});
}

function unlike(pin)
{
	$.getJSON("?page=Board&action=Unlike&pin=" + pin, function(data) {
		loadPin(pin, data);
	});
}

function loadPin(id, object)
{
	$("#pin_" + id + " > .date > #like > .likes_count_number").html(object.likes);
	$("#pin_" + id + " > .date > #dislike > .likes_count_number").html(object.dislikes);
	
	if(object.unliked)
		$("#pin_" + id + " > #like_buttons").html('<a class="like clickable" onclick="like(' + id + ')"></a><a class="dislike clickable" onclick="dislike(' + id + ')"></a>');
	else
		$("#pin_" + id + " > #like_buttons").html('<a class="clickable" onclick="unlike(' + id + ')">Zurücknehmen</a>');
}