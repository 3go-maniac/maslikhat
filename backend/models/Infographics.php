<?php

namespace backend\models;

use Yii;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;

class Infographics extends \common\models\ImageWithDescription
{
    public $tmpImage;

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->created_at = time();
            if ($this->tmpImage) {
                $this->image = rand(0, 9999) . '-' . time() . '-infographics.' . $this->tmpImage->extension;
                if (!$this->isNewRecord) {
                    $this->deleteOldImage();
                    $this->deleteOldSmallImage();
                }
                $this->uploadImage();
            }
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $this->deleteOldImage();
        $this->deleteOldSmallImage();
        return parent::beforeDelete();
    }

    protected function uploadImage()
    {
        if ($this->validate()) {
            if ($this->tmpImage) {
                if (Image::thumbnail($this->tmpImage
                        ->tempName, 1200, 2000, ManipulatorInterface::THUMBNAIL_OUTBOUND)
                        ->save(Yii::getAlias('@frontend') . '/web/uploads/infographics-images/' . $this->image, ['quality' => 80])
                    &&
                    Image::thumbnail($this->tmpImage
                        ->tempName, 260, 350, ManipulatorInterface::THUMBNAIL_OUTBOUND)
                        ->save(Yii::getAlias('@frontend') . '/web/uploads/infographics-images/small/' . $this->image, ['quality' => 80])
                ) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    protected function deleteOldImage()
    {
        $oldImage = Yii::getAlias('@frontend') . '/web/uploads/infographics-images/' . $this->getOldAttribute('image');
        if (!unlink($oldImage)) {
            return false;
        }
    }

    protected function deleteOldSmallImage()
    {
        $oldSmallImage = Yii::getAlias('@frontend') . '/web/uploads/infographics-images/small/' . $this->getOldAttribute('image');
        if (!unlink($oldSmallImage)) {
            return false;
        }
    }
}
