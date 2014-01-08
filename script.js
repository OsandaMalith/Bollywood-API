

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
	$("#btnSignup").val("Loading...");
	$.ajax({
		url: "v1/frontend_wrapper.php",
		data: {
			call: "signup",
			email: $("#txtEmail").val()
		},
		success: function(data)
		{
			$("btnSignup").val("Signup");
			notify($.parseJSON(data).message);
		}
	});
}

function search()
{
	$("#btnSearch").val("Loading..");
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
			$("#btnSearch").val("Done!");
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