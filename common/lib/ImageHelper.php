<?php
/**
 * Message: 图片处理助手
 * User: jzc
 * Date: 2018/11/1
 * Time: 11:52 PM
 * Return:
 */

namespace common\lib;


class ImageHelper
{
    //图片最大质量
    const MAX_JPG_QUALITY = 100;
    const MAX_PNG_QUALITY = 9;

    public function outputImage()
    {

    }

    /**
     * 对原图片按要求尺寸进行缩放
     * @param $srcFile //源文件
     * @param $objFile  //输出文件
     * @param $newWidth
     * @param $newHeight
     * @param int $quality  //输出图片质量，0 - 10
     * @param bool $keepFormat  //如果你需要保持原图片的横版或竖版，请设为true
     * @return bool
     */
    public function setImageSize($srcFile, $objFile, $newWidth, $newHeight, $quality = 7, $keepFormat = false)
    {
        if (!file_exists($srcFile)) {
            return false;
        }

        if ($newWidth < 1 || $newHeight < 1) {
            return false;
        }

        if ($quality < 0 || $quality >10) {
            return false;
        }

        $type = exif_imagetype($srcFile);
        $supportType = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
        if (!in_array($type, $supportType, true)) {
            return false;
        }

        //加载图片
        switch($type) {
            case IMAGETYPE_JPEG :
                $srcImg = imagecreatefromjpeg($srcFile);
                break;
            case IMAGETYPE_PNG :
                $srcImg = imagecreatefrompng($srcFile);
                break;
            case IMAGETYPE_GIF :
                $srcImg = imagecreatefromgif($srcFile);
                break;
            default:
                return false;
        }

        $w = imagesx($srcImg);
        $h = imagesy($srcImg);
        //保持版式，即保持原图的宽大于高或高大于宽的格式，防止变形
        if ($keepFormat) {
            if (($w < $h && $newWidth > $newHeight) || ($w > $h && $newWidth < $newHeight)) {
                list($newWidth, $newHeight) = array($newHeight, $newWidth);
            }
        }

        //将原图数据写入新图
        //注意--是否需要alpha通道按情况判断，不需要可以注释掉以节省内存和空间
        $newImg = imagecreatetruecolor($newWidth, $newHeight);
        $alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);//alpha
        imagefill($newImg, 0, 0, $alpha);//alpha
        imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $w, $h);
        imagesavealpha($newImg, true);//alpha

        switch($type) {
            case IMAGETYPE_JPEG :
                imagejpeg($newImg, $objFile,$quality * 10); // 存储图像
                break;
            case IMAGETYPE_PNG :
                imagepng($newImg, $objFile, intval($quality / 10 * 9));
                break;
            case IMAGETYPE_GIF :
                imagegif($newImg, $objFile);
                break;
            default:
                break;
        }

        return true;
    }
}