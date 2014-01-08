

function openModal()
{
	$("#modal").css("display", "block");
}

function closeModal()
{
	$("#modal").css("display", "none");
}

function textbox(textbox, defaultVal)
{
	if ($(textbox).css("color") == "rgb(148, 148, 148)")
	{
		$(textbox).val("");
		$(textbox).css("color", "#3d3d3d")
	}
	else if($(textbox).val() == "")
	{
		$(textbox).css("color", "rgb(148, 148, 148)");
		$(textbox).val(defaultVal);
	}
}

function signup()
{
	$.ajax({
		url: "v1/frontend_wrapper.php",
		data: {
			call: "signup",
			email: $("#txtEmail").val()
		},
		success: function(data)
		{
			notify($.parseJSON(data).message);
		}
	});
}

function search()
{
	$.ajax({
		url: "v1/frontend_wrapper.php",
		data: {
			call: "search",
			name: $("#txtSearch").val()
		},
		success: function(data)
		{
			$("#searchResults").text(JSON.stringify($.parseJSON(data), undefined, 4));
			$("#searchResults").css("display", "block");
		}
	})
}

function notify(text)
{
	$("#notification").text(text);
	$("#notification").css("display", "block");
	setTimeout(function () {
		$("#notification").css("display", "none");
	}, 3000);
}