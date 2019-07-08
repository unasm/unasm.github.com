<?php
/**
 *  本文见的功能就是在添加文件之后，更新文章对应的列表
 *  本文件的意义在于一定程度上学习模仿模板的原理,而且一定程度上可以规避静态网站的缺点
*    @name:       refresh.php
*    @author:     unasm<1264310280@qq.com>
*    @since :     2014-04-19 13:59:41
*/
Define("HREF" , "http://unasm.github.io/");
Define("TPL"  , 'index.tpl.php');
class Refresh{
    private $tplHandle;
    /**
     * 筹备数据，为接下来的解析准备
     */
    function __construct($path){
        $data['fileList'] = $this->readFile($path);
        $data['title'] = "unasm的博客";
        $data['domain'] = HREF;
        //将数据传入，减少于外界的耦合
        $this->parseIndex($data, TPL);
    }
    /**
     * 读取当前文件夹下面所有的html文件
     * @todo  实现按照时间顺序进行排序，具体巩固filemtime的方式获取修改时间，
     */
    function readFile($path){
        $fileList = [];
        if(is_dir($path)){
            $dir = opendir($path);
            if(!$dir){
                exit("打开文件夹失败" . __LINE__ . "行\n");
            }
            while(($fileName = readdir($dir)) !== false){
                if((substr($fileName,-5) === '.html') && is_file($path . $fileName)){
                    if($fileName !== 'index.html'){
                        $fileList [] = $fileName;
                    }
                }
            }
        } else{
            echo "路径并非是文件夹";
        }
        closedir($dir);
        return $fileList;
    }

    /**
     * 开始解析生成模板数据index.php
     * 因为是生成的目录，所以默认生成的文件名子是index.html
     */
    function parseIndex($data, $tplPath){
        foreach($data as $idx => $value){
            $$idx = $value;
        }
        ob_start();
        include $tplPath;
        $tpl = ob_get_contents();
        ob_end_clean();
        $fp = @fopen('index.html', 'w') or die("打开文件index.html失败");
        if(flock($fp, LOCK_EX)){
            fwrite($fp , $tpl);
            fflush($fp);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
    /**
     * 生成数据文件
     */
    public function parseFile($filepath){
        $file = fopen($filePath , true);
        $fileName = basename($filePath);
        if(!$this->tplHandle){
            exit("模板文件尚未初始化");
        }

        fclose($file);
    }
    /**
     * 初始化数据的模板文件
     */
    protected function initDataTpl(){
        $this->tplHandle = fopen("./tplData.tpl.html");
    }
    function __destruct(){
        if($this->tplHandle){
            fclose($this->tplHandle);
        }
    }
}
$oper = new Refresh("./");
?>
