<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php if ($lang == "1") { ?>用户广场<?php } else { ?>User Square<?php } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <style>

        html, body {
            padding: 0px;
            margin: 0px;
            font-family: PingFangSC-Regular, "MicrosoftYaHei";
            width: 100%;
            background: rgba(245, 245, 245, 1);
            font-size: 14px;
            overflow-x: hidden;
            /*overflow-y: scroll;*/
        }

        .wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: stretch;
        }

        .layout-all-row {
            width: 100%;
            /*background: white;*/
            background: rgba(245, 245, 245, 1);;
            display: flex;
            align-items: stretch;
            overflow: hidden;
            flex-shrink: 0;

        }

        .item-row {
            background: rgba(255, 255, 255, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 60px;
        }

        /*.item-row:hover{*/
        /*background: rgba(255, 255, 255, 0.2);*/
        /*}*/

        .item-row:active {
            background: rgba(255, 255, 255, 0.2);
        }

        .item-header {
            width: 50px;
            height: 50px;
        }

        .user-avatar-image {
            width: 44px;
            height: 44px;
            margin-top: 8px;
            margin-bottom: 8px;
            margin-left: 10px;
            border-radius: 50%;
        }

        .item-body {
            width: 100%;
            height: 50px;
            margin-left: 1rem;
            margin-top: 7px;
            flex-direction: row;
        }

        .list-item-center {
            width: 100%;
            /*height: 11rem;*/
            /*background: rgba(255, 255, 255, 1);*/
            padding-bottom: 11px;
            /*padding-left: 1rem;*/

        }

        .item-body-display {
            display: flex;
            justify-content: space-between;
            /*margin-right: 7rem;*/
            /*margin-bottom: 3rem;*/
            line-height: 3rem;
        }

        .item-body-tail {
            margin-right: 10px;
        }

        .item-body-desc {
            height: 3rem;
            font-size: 16px;
            font-family: PingFangSC-Regular;
            /*color: rgba(76, 59, 177, 1);*/
            margin-left: 11px;
            line-height: 3rem;
        }

        .more-img {
            width: 8px;
            height: 13px;
            /*border-radius: 50%;*/
        }

        .division-line {
            height: 1px;
            background: rgba(243, 243, 243, 1);
            margin-left: 40px;
            overflow: hidden;
        }

        .addButton {
            width: 80px;
            height: 28px;
            background: rgba(76, 59, 177, 1);
            border-radius: 4px;
            border-width: 0;
            font-size: 14px;
            font-family: PingFangSC-Regular;
            font-weight: 400;
            color: rgba(255, 255, 255, 1);
        }


    </style>

    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.0/css/jquery-weui.css"/>
</head>

<body id="square-body">

<div class="wrapper" id="wrapper">
    <div class="layout-all-row">

        <div class="list-item-center">

            <?php foreach ($userList as $i => $user) { ?>
                <!--                <div class="item-row user-id-item" userId="--><?php //echo $user['userId'] ?><!--">-->
                <div class="item-row" userId="<?php echo $user['userId'] ?>" avatar="<?php echo $user['avatar'] ?>">
                    <div class="item-header">
                        <img class="user-avatar-image"
                             src="/_api_file_download_/?fileId=<?php echo $user['avatar'] ?>"
                             onerror="this.src='../../public/img/msg/default_user.png'"/>
                    </div>
                    <div class="item-body">
                        <div class="item-body-display">
                            <div class="item-body-desc">
                                <?php echo $user['nickname'] ?>
                            </div>

                            <div class="item-body-tail">

                                <?php if (!$user['isFollow']) { ?>
                                    <button class="addButton" onclick="applyAddFriend('<?php echo $user['userId'] ?>')">
                                        添加好友
                                    </button>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="division-line"></div>
            <?php } ?>


        </div>

    </div>

</div>

<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/jquery-weui/1.2.0/js/jquery-weui.js"></script>

<script type="text/javascript">

    function isAndroid() {

        var userAgent = window.navigator.userAgent.toLowerCase();
        if (userAgent.indexOf("android") != -1) {
            return true;
        }

        return false;
    }

    function isMobile() {
        if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
            return true;
        }
        return false;
    }

    function getLanguage() {
        var nl = navigator.language;
        if ("zh-cn" == nl || "zh-CN" == nl) {
            return 1;
        }
        return 0;
    }

    function zalyjsNavOpenPage(url) {
        var messageBody = {}
        messageBody["url"] = url
        messageBody = JSON.stringify(messageBody)

        if (isAndroid()) {
            window.Android.zalyjsNavOpenPage(messageBody)
        } else {
            window.webkit.messageHandlers.zalyjsNavOpenPage.postMessage(messageBody)
        }
    }

    function zalyjsCommonAjaxGet(url, callBack) {
        $.ajax({
            url: url,
            method: "GET",
            success: function (result) {

                callBack(url, result);

            },
            error: function (err) {
                alert("error");
            }
        });

    }


    function zalyjsCommonAjaxPost(url, value, callBack) {
        $.ajax({
            url: url,
            method: "POST",
            data: value,
            success: function (result) {
                callBack(url, value, result);
            },
            error: function (err) {
                alert("error");
            }
        });

    }

    function zalyjsCommonAjaxPostJson(url, jsonBody, callBack) {
        $.ajax({
            url: url,
            method: "POST",
            data: jsonBody,
            success: function (result) {

                callBack(url, jsonBody, result);

            },
            error: function (err) {
                alert("error");
            }
        });

    }

    /**
     * _blank    在新窗口中打开被链接文档。
     * _self    默认。在相同的框架中打开被链接文档。
     * _parent    在父框架集中打开被链接文档。
     * _top    在整个窗口中打开被链接文档。
     * framename    在指定的框架中打开被链接文档。
     *
     * @param url
     * @param target
     */
    function zalyjsCommonOpenPage(url) {
        // window.open(url, target);
        location.href = url;
    }

    function zalyjsCommonOpenNewPage(url) {
        if (isMobile()) {
            zalyjsNavOpenPage(url);
        } else {
            // window.open(url, target);
            location.href = url;
        }
    }

</script>

<script type="text/javascript">

    var currentPageNum = 2;
    // var pageSize = 12;
    var loading = true;

    // $(function () {
    //     alert(currentPageNum);
    // });

    // $(".user-id-item").click(function () {
    //     var userId = $(this).attr("userId");
    //
    //     alert(userId);
    // });


    function applyAddFriend(friendUserId) {
        var data = {
            'friendId': friendUserId
        };

        var url = "index.php?action=miniProgram.square.apply";
        zalyjsCommonAjaxPostJson(url, data, applyResponse)
    }

    function applyResponse(url, data, result) {
        var res = JSON.parse(result);

        alert(res.errCode);
    }

    $(window).scroll(function () {
        //判断是否滑动到页面底部
        if ($(window).scrollTop() === $(document).height() - $(window).height()) {

            if (!loading) {
                return;
            }

            loadMoreUsers();
        }
    });

    function loadMoreUsers() {

        var data = {
            'pageNum': currentPageNum++,
        };

        var url = "index.php?action=miniProgram.square.index";
        zalyjsCommonAjaxPostJson(url, data, loadMoreResponse)
    }

    function loadMoreResponse(url, data, result) {

        alert("pageNum=" + data['pageNum'] + " pageSize=" + data['pageSize'] + " isloading=" + loading);
        if (result) {
            var res = JSON.parse(result);

            var isloading = res['loading'];
            loading = isloading;
            var data = res['data'];

            // alert(result);
            if (data && data.length > 0) {
                $.each(data, function (index, user) {
                    var userHtml = '<div class="item-row" userId="' + user["userId"] + '" >'
                        + '<div class="item-header">'
                        + '<img class="user-avatar-image" src="/_api_file_download_/?fileId=' + user['avatar'] + '" onerror="this.src=\'../../public/img/msg/default_user.png\'" />'
                        + '</div>'
                        + '<div class="item-body">'
                        + '<div class="item-body-display">'
                        + '<div class="item-body-desc">' + user["nickname"] + '</div>'
                        + '<div class="item-body-tail">';

                    if (!user['isFollow']) {
                        userHtml += '<button class="addButton" onclick="applyAddFriend(\'' + user["userId"] + '\')">添加好友</button>';
                    }


                    userHtml += '</div></div></div></div>';
                    userHtml += '<div class="division-line"></div>';

                    $(".list-item-center").append(userHtml);
                });
            }

        }

    }

</script>

</body>
</html>




