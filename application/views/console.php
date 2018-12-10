<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Rest API">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?= $title ?></title>

        <script type="text/javascript">var base_url = "<?php echo base_url(); ?>";</script>

        <?php
        echo link_tag('resources/css/bootstrap.min.css');
        echo link_tag('resources/css/font-awesome.min.css');
        echo link_tag('resources/css/jquery-ui.min.css');
        ?>

        <style>
            #json_output {
                padding: 0 3%;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-inverse ">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">API Console</a>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-3 col-xs-offset-1">
                    <div class="list-group">
                        <?php
                        foreach ($api as $v) {
                            ?>
                            <a href="#" class="list-group-item api-nav" data-user_req="<?= intval($v['user_required']); ?>" data-api="<?= $v['name']; ?>" data-post="<?= $v['post']; ?>"><?= $v['title'] ?></a>
                            <?php
                        }
                        ?>
                    </div> 
                </div>
                <div class="col-xs-7">
                    <form class="form-horizontal ">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Method:</label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input name="method" value="GET" type="radio">GET</label>
                                <label class="radio-inline"><input name="method" value="POST" type="radio">POST</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">URL:</label>
                            <div class="col-sm-10">
                                <input name="url" value="" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Query Parameter:</label>
                            <div class="col-sm-10">
                                <input name="queryParameter" value="" class="form-control" type="text" disabled="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Token key:</label>
                            <div class="col-sm-6">
                                <input name="token_key" value="1234567890" class="form-control" type="text">
                                <input name="iat" value="<?= base64_encode(time()); ?>" class="form-control" type="hidden">
                            </div>
                            <label class="control-label col-sm-2">User ID:</label>
                            <div class="col-sm-2">
                                <input name="user_id" value="" class="form-control" type="text" disabled="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Session Token:</label>
                            <div class="col-sm-10">
                                <input name="session_token" value="" class="form-control" type="text" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Body:</label>
                            <div class="col-sm-10">
                                <textarea name="requestBody" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button disabled="true" onclick="callApi()" type="button" class="btn btn-primary" id="submit">Submit</button>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Hash Signature:</label>
                            <div class="col-sm-10">
                                <textarea id="hash_signature" class="form-control" readonly></textarea>
                            </div>
                        </div>
                        <br><br>

                        <pre>
                            <div id="json_output"></div>
                        </pre>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <?php
            echo $start_script . base_url('resources/js/jquery-1.11.1.js') . $end_script;
            echo $start_script . base_url('resources/js/bootstrap.min.js') . $end_script;
            echo $start_script . base_url('resources/js/jquery.validate.min.js') . $end_script;
            echo $start_script . base_url('resources/js/jquery-ui.min.js') . $end_script;
            ?>
            <script src="//cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/hmac-sha256.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/enc-base64-min.js"></script>
            <?php
            echo $start_script . base_url('resources/js/console.js') . $end_script;
            ?>
        </footer>
    </body>
</html>