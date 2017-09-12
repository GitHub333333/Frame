function modalDel(url){
    var str = "<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">\n" +
        "        <div class=\"modal-dialog\" role=\"document\">\n" +
        "            <div class=\"modal-content\">\n" +
        "                <div class=\"modal-header\">\n" +
        "                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>\n" +
        "                    <h4 class=\"modal-title \" id=\"myModalLabel\">删除</h4>\n" +
        "                </div>\n" +
        "                <div class=\"modal-body\">\n" +
        "                    确认删除么? \n" +
        "                </div>\n" +
        "                <div class=\"modal-footer\">\n" +
        "                    <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">取消</button>\n" +
        "                    <a href="+url+" class=\"btn btn-danger\">删除</a>\n" +
        "                </div>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>";

    $('body').append(str);
    $('#myModal').modal('show')
}