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
                    <table id="tableLists" class="table table-striped">
                        <thead>
                            <td>list</td>
                            <td>stats</td>
                            <td></td>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    
                    <form id="createList">
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
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                    </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        
        <script>
            var getList = function() {
                $.getJSON( "list", function( data ) {
                    if(typeof(data.lists) != "undefined" && data.lists.length>0)
                    {
                        var items = [];
                        $.each( data.lists, function( key, val ) {
                            items.push( "<tr><td>"+val.name+"</td><td>"+(typeof(val.stats) != "undefined" ? val.stats.member_count : 0)+"</td><td><a onclick=\"edit('"+val.id+"')\">edit</a></td></tr>" );
                        });
                        $('#tableLists > tbody:last-child').html(items.join(""));
                    }
                });
            }
            $( "#createList" ).submit(function( event ) {
                data = $(this).serialize();
                var jqxhr = $.post( "list", data, function() {
                    getList();
                })
                .fail(function() {
                    alert( "error" );
                })
                event.preventDefault();
            });
            
            getList();
        </script>
    </body>
</html>