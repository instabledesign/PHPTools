<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Editor</title>
    <style type="text/css" media="screen">
        body {
            margin: 0;
        }
        .ace_status-indicator {
            color: gray;
            position: absolute;
            right: 0;
            border-left: 1px solid;
        }

        #editor {
            margin: 0;
            height: 300px;
        }
        fieldset {
            border: 1px solid #000;
            margin: 20px 10px;
        }
        iframe {
            border: 0;
            width: 100%;
            height: 300px;
        }
    </style>
</head>
<body>

<pre id="editor"><&#63;php
$params = array('level' => 6, 'window' => 15, 'memory' => 9);

echo implode(', ', $params);
</pre>
<div id="statusBar">
    <form name="eval" method="post">
        <input type="hidden" name="code" id="code">
        <?php foreach (['5.6' => true, '7.0' => true, '7.1' => true, '7.2' => true] as $phpVersion => $enable): ?>
            <label>PHP<?=$phpVersion;?><input name="php[]" value="php<?= $phpVersion;?>" type="checkbox" <?php echo $enable ? 'checked="checked"':''?>></label>
        <?php endforeach ?>
    <button onclick="multipleSubmit()">Execute</button>
    </form>
</div>
<div id="result"></div>
<script src="src/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="src/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="src/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
<script src="src/ext-statusbar.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    var StatusBar = ace.require("ace/ext/statusbar").StatusBar;
    var statusBar = new StatusBar(editor, document.getElementById("statusBar"));
    editor.setTheme("ace/theme/twilight");
    editor.session.setMode("ace/mode/php");
    editor.setOptions({
        enableLiveAutocompletion: true,
        enableBasicAutocompletion: true,
        useSoftTabs: true,
        navigateWithinSoftTabs: false
    });
    editor.commands.addCommand({
        name: "Execute",
        bindKey: {win: "Ctrl-Enter", mac: "Command-Enter"},
        exec: function(editor) {
            multipleSubmit();
        }
    });
    var $result = $('#result');
    var $versionSelect = $('input[name="php[]"]');
    $versionSelect.on('change', function(){
        if ($(this).is(':checked')) {
            $result.prepend($('<fieldset id="fieldset_'+this.value+'"><legend>PHP'+this.value+'</legend><iframe name="'+this.value+'"></iframe></fieldset>'));
        }else {
            $('#fieldset_'+this.value).remove();
        }
    });
    $versionSelect.trigger('change');

    function multipleSubmit(){
        var evalForm = document.forms['eval'];
        document.getElementById('code').setAttribute('value', editor.getValue());
        $('iframe').each(function(){
            var $this = $(this);
            evalForm.action = 'executor.php?nginx_php='+$this.attr('name');
            evalForm.target = $this.attr('name');
            evalForm.submit();
        });
    }
</script>
</body>
</html>
