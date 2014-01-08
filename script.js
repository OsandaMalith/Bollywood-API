

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