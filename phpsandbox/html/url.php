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

        #url {
            width: -webkit-fill-available;
            padding: 10px;
            font-size: 24px;
            margin: 10px;
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
<div id="statusBar">
    <form name="eval" method="post">
        <div><input type="text" id="url" value="http://localhost/phpinfo.php"/></div>
        <?php foreach (['5.6' => true, '7.0' => true, '7.1' => true, '7.2' => true] as $phpVersion => $enable): ?>
            <label>PHP<?= $phpVersion; ?><input name="php[]" value="php<?= $phpVersion; ?>"
                                                type="checkbox" <?php echo $enable ? 'checked="checked"' : '' ?>></label>
        <?php endforeach ?>
        <button onclick="multipleSubmit();return false;">Execute</button>
    </form>
</div>
<div id="result"></div>
<script src="src/jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    var $result = $('#result');
    var $versionSelect = $('input[name="php[]"]');
    $versionSelect.on('change', function () {
        if ($(this).is(':checked')) {
            $result.prepend($('<fieldset id="fieldset_' + this.value + '"><legend>PHP' + this.value + '</legend><iframe name="' + this.value + '"></iframe></fieldset>'));
        } else {
            $('#fieldset_' + this.value).remove();
        }
    });
    $versionSelect.trigger('change');

    function multipleSubmit() {
        $('iframe').each(function () {
            var $this = $(this);
            var link = document.createElement('a');
            link.href = $('#url').val();
            link.search += 0 === link.search.length ? '?' : '&';
            link.search += 'nginx_php=' + $this.attr('name');
            console.log($this, link.href);
            $this.attr('src', link.href);
        });
    }
</script>
</body>
</html>
