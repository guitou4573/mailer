<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="page-header">
                        Mailchimp API demo
                    </div>        
                    <table id="tableLists" class="table table-hover table-bordered">
                        <thead>
                            <td>list</td>
                            <td>stats</td>
                            <td></td>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-info btn-s" data-toggle="modal" data-target="#addLists">
                    Add List
                    </button>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        
        <div class="modal fade" id="addLists" tabindex="-1" role="dialog" aria-labelledby="Add subscriber">
            <div class="modal-dialog" role="document">
                <form id="createList">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add subscriber</h4>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label for="listname">List name</label>
                                    <input type="text" class="form-control" id="listname" name="listname" placeholder="My list">
                                    <label for="listemailfrom">Email from</label>
                                    <input type="email" class="form-control" id="listemailfrom"name="listemailfrom"  placeholder="my@email">
                                    <label for="listnamefrom">Name from</label>
                                    <input type="text" class="form-control" id="listnamefrom"name="listnamefrom"  placeholder="My name">
                                </div>
                                <div class="form-group">
                                    <label for="reminder">Reminder</label>
                                    <textarea class="form-control" id="reminder" name="reminder" placeholder="Reminder"></textarea>
                                    <label for="contact">Contact information</label>
                                    <textarea class="form-control" id="contact" name="contact" readonly placeholder="">DumLi
1 Wandaa Crt
Coolum Beach, Qld 4573</textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="modal fade" id="addSubs" tabindex="-1" role="dialog" aria-labelledby="Add subscriber">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add subscriber</h4>
                    </div>
                    <form id="createSub">
                        <div class="modal-body">
                            <input type="hidden" id="listid" name="listid">
                            <input type="hidden" id="hash" name="hash">
                            <div class="form-group">
                                <label for="emailsub">Email address</label>
                                <input type="email" class="form-control" id="emailsub" name="emailsub" placeholder="Email">
                            </div>
                            <div class="checkbox">
                                <label>
                                <input type="checkbox" name="confirmed" value="1"> This person gave me permission to email them
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            var members = {};
            var getList = function() {
                $.getJSON( "list", function( data ) {
                    if(typeof(data.lists) != "undefined" && data.lists.length>0)
                    {
                        var items = [];
                        $.each( data.lists, function( key, val ) {
                            if(!members[val.id])
                            {
                                members[val.id] = {};
                            }
                            items.push( "<tr id=\"mem_"+val.id+"\"><td>"+val.name+"</td><td>"+(typeof(val.stats) != "undefined" ? val.stats.member_count : 0)+"</td><td><button type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#addSubs\" data-listid=\""+val.id+"\">Add subscriber</button></td></tr>" );
                            if(typeof(val.stats) != "undefined" && val.stats.member_count > 0)
                            {
                                data = {
                                    "listid" : val.id,
                                };
                                $.getJSON( "subscriber", data, function( data ) {
                                    if(typeof(data.members) != "undefined" && data.members.length>0)
                                    {
                                        $.each( data.members, function( key, val ) {
                                            members[data.list_id][val.id] = val;
                                            $("#mem_"+val.list_id).after( "<tr><td>"+val.email_address+"</td><td>"+val.status+"</td><td><button type=\"button\" class=\"btn btn-info btn-xs\" data-toggle=\"modal\" data-target=\"#addSubs\" data-memid=\""+val.id+"\" data-listid=\""+val.list_id+"\">Edit</button></td></tr>" );
                                        });
                                    }
                                });
                            }
                        });
                        $('#tableLists > tbody:last-child').html(items.join(""));
                    }
                });
            }
            $( "#createList" ).submit(function( event ) {
                data = $(this).serialize();
                var jqxhr = $.post( "list", data, function() {
                    $('#addLists').modal('hide')
                    getList();
                })
                .fail(function() {
                    alert( "error" );
                })
                event.preventDefault();
            });
            $( "#createSub" ).submit(function( event ) {
                data = $(this).serialize();
                var jqxhr = $.post( "subscriber", data, function() {
                    $('#addSubs').modal('hide');
                    $('#hash').val("");
                    getList();
                })
                .fail(function() {
                    alert( "error" );
                    $('#hash').val("");
                })
                event.preventDefault();
                });
                $('#addSubs').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget)
                    var listid = button.data('listid') 
                    var modal = $(this)
                    modal.find('#listid').val(listid)
                    var memid = button.data('memid')
                    if(memid)
                    {
                        mem = members[listid][memid];
                        modal.find('#emailsub').val(mem.email_address)
                        modal.find('#hash').val(mem.id)
                    }
                })
            
            getList();
        </script>
    </body>
</html>