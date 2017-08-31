
 var mhy={};
 (function(heyuan){


     heyuan.post=function(url,data,mhycallback){
         $.post(url,data,mhycallback);
     };
     heyuan.get=function(url,mhycallback){
         $.get(url,mhycallback);
     }

     heyuan.createData=function(node){
         title=$(node).attr("title");
         url=$(node).attr("data-url");
         layer.open({
             type: 2,
             title: title,
             shadeClose: true,
             shade: 0.8,
             area: ['80%', '80%'],
             content: url //iframe的url
         });
     };
     heyuan.updateData=function(node){
         title=$(node).attr("title");

         url=$(node).attr("data-url");
         layer.open({
             type: 2,
             title: title,
             shadeClose: true,
             shade: 0.8,
             area: ['80%', '80%'],
             content: url
         });
     };

     heyuan.deleteData=function(node){
         id=$(node).attr("data-id");
         url=$(node).attr("data-url");
         mhyDeleteCallBack=function(data,status){
             if(data.status==1){

                 $("#row"+id).remove();
                 layer.msg('删除成功!', {icon: 1});
             }
             else{
                 layer.msg('删除失败!', {icon: 2});
             }
         };
         layer.confirm('您确认删除吗？',
             {
                btn: ['确认','取消'] //按钮
             },
             function(){
                heyuan.post(url,{},mhyDeleteCallBack);
             },
             function(){
             layer.msg('取消成功!', {icon: 2});
            }
         );
     };

 })(mhy);





$(function(){
    $(".create").click(function(){
        mhy.createData(this);
    });
    $(".update").click(function(){
        mhy.updateData(this);
    });
    $(".delete").click(function(){
        mhy.deleteData(this);
    });
});