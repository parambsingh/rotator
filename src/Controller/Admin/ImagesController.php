<?php

namespace App\Controller\Admin;

/**
 * Images Controller
 *
 * @property \App\Model\Table\ImagesTable $Images
 *
 * @method \App\Model\Entity\Image[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImagesController extends AppController {


    public $thumb;
    public $fileName;
    public $fileExt;
    public $actualWidth;
    public $actualHeight;


    public function imageMedia($type = "Users", $category = "Profile", $userId = 3) {
        $this->viewBuilder()->setLayout(null);
        $this->set(compact('type', 'userId', 'category'));

    }

    public function mediaLibrary() {
        $this->viewBuilder()->setLayout(false);
    }

    public function upload() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;


        if ($this->request->is(['patch', 'post', 'put'])) {

            $file = $this->request->getData('file');
            $clientFileName = $file->getClientFilename();
            $fileSize = $file->getSize();

            $this->fileExt = pathinfo($clientFileName, PATHINFO_EXTENSION);

            $this->fileName = uniqid() . "." . $this->fileExt;
            $imagePath = WWW_ROOT . 'files/images/' . $this->fileName;
            $filePath = WWW_ROOT . 'files/' . $this->fileName;
            $imageUrl = SITE_URL . 'files/images/' . $this->fileName;

            if (!is_writable(WWW_ROOT . 'files/images/')) {

                if (!file_exists(WWW_ROOT . 'files')) {
                    mkdir(WWW_ROOT . 'files');
                }
                if (!file_exists(WWW_ROOT . 'files/images')) {
                    mkdir(WWW_ROOT . 'files/images');
                }
                if (!file_exists(WWW_ROOT . 'files/images')) {
                    mkdir(WWW_ROOT . 'files/images');
                }
                if (!file_exists(WWW_ROOT . 'files/images/thumbs')) {
                    mkdir(WWW_ROOT . 'files/images/thumbs');
                }
                chmod(WWW_ROOT . 'files', 0777);
            }


            if ($fileSize <= 50320921) {
                if (in_array(strtolower($this->fileExt), [
                    'jpg',
                    'jpeg',
                    'png',
                    'gif',
                    'pdf',
                    'csv',
                    'xlsx',
                    'xls',
                    'doc',
                    'docx'
                ])) {
                    if (in_array(strtolower($this->fileExt), ['jpg', 'jpeg', 'png', 'gif'])) {
                        $file->moveTo($imagePath);

                        $image = $this->Images->newEmptyEntity();

                        $image->image = 'files/images/' . $this->fileName;
                        $image->file_type = 'IMAGE';
                        if ($this->Auth->user()) {
                            $image->user_id = empty($this->request->getData('user_id')) ? $this->Auth->user('id') : $this->request->getData('user_id');
                        } else {
                            $image->user_id = empty($this->request->getData('user_id')) ? 0 : $this->request->getData('user_id');
                        }
                        $image->category = empty($this->request->getData('category')) ? 'Profile' : $this->request->getData('category');

                        $this->loadComponent('Thumb');
                        $this->thumb = $this->Thumb;


                        list($this->actualWidth, $this->actualHeight) = getimagesize($imageUrl);


                        $image->small_thumb = $this->createThumb('small', SMALL_THUMB_WIDTH);
                        $image->medium_thumb = $this->createThumb('medium', MEDIUM_THUMB_WIDTH);
                        $image->large_thumb = $this->createThumb('large', LARGE_THUMB_WIDTH);

                        if ($this->Images->save($image)) {
                            $this->responseData = $image;
                            $this->responseMessage = __('<b>' . $clientFileName . '</b> - Thank you! Uploaded successfully');
                            $this->responseCode = SUCCESS_CODE;
                        } else {
                            $this->responseMessage = $image->getErrors();
                        }

                    } else if (in_array(strtolower($this->fileExt), ['pdf', 'csv', 'xlsx', 'xls', 'doc', 'docx'])) {
                        $file->moveTo($imagePath);
                        $image = $this->Images->newEmptyEntity();

                        $image->image = 'files/' . $this->fileName;
                        $image->file_type = 'FILE';
                        if ($this->Auth->user()) {
                            $image->user_id = empty($this->request->getData('user_id')) ? $this->Auth->user('id') : $this->request->getData('user_id');
                        } else {
                            $image->user_id = empty($this->request->getData('user_id')) ? 0 : $this->request->getData('user_id');
                        }
                        $image->category = empty($this->request->getData('category')) ? 'FILE' : $this->request->getData('category');

                        $image->small_thumb = 'files/images/thumbs/small_file.png';
                        $image->medium_thumb = 'files/images/thumbs/medium_file.png';
                        $image->large_thumb = 'files/images/thumbs/large_file.png';

                        if ($this->Images->save($image)) {
                            $this->responseData = $image;
                            $this->responseMessage = __('<b>' . $clientFileName . '</b> - Thank you! Uploaded successfully');
                            $this->responseCode = SUCCESS_CODE;
                        } else {
                            $this->responseMessage = $image->getErrors();
                        }

                    } else {
                        $this->responseMessage = __("Only JPG, JPEG, PNG, PDF, CSV, XLSX, XLS, DOC & DOCX  files are allowed.");
                    }
                } else {
                    $this->responseMessage = __("Sorry, the file is too large.");
                }
            } else {
                $this->responseMessage = __("Video file is too large, file must be less than 50 MB in size.");
            }

        }

        echo $this->responseFormat();
        exit;
    }

    public
    function uploadVideo() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;


        if ($this->request->is(['patch', 'post', 'put'])) {

            $file = $this->request->getData('file');
            $clientFileName = $file->getClientFilename();
            $fileSize = $file->getSize();

            $this->fileExt = pathinfo($clientFileName, PATHINFO_EXTENSION);

            $this->fileName = uniqid() . "." . $this->fileExt;

            $filePath = WWW_ROOT . 'files/' . $this->fileName;

            if ($fileSize <= 50320921) {
                if (in_array(strtolower($this->fileExt), [
                    'mp4',
                    'webm'
                ])) {

                    $file->moveTo($filePath);

                    $ffmpeg = '/usr/bin/ffmpeg';
//                        $convert_status = ['mp4' => 0, 'webm' => 0];
//
//                        // MP4
//                        if(strtolower($this->fileExt) != "mp4") {
//                            $video_mp4 = WWW_ROOT . 'files/' . $fileName . '.mp4';
//                            exec($ffmpeg . ' -i "' . $filePath . '" -c:v libx264 -an "' . $video_mp4 . '" -y 1>convert.txt 2>&1', $output, $convert_status['mp4']);
//
//                        }
//
//                        // WebM
//                        if(strtolower($this->fileExt) != "webm") {
//                            $video_webm = WWW_ROOT . 'files/' . $fileName . '.webm';
//                            exec($ffmpeg . ' -i "' . $filePath . '" -c:v libvpx -c:a libvorbis -an "' . $video_webm . '" -y 1>convert.txt 2>&1', $output, $convert_status['webm']);
//                        }

                    $this->loadModel('Videos');

                    $video = $this->Videos->newEmptyEntity();

                    $video->video = 'files/' . $this->fileName;

                    if ($this->Auth->user()) {
                        $video->user_id = empty($this->request->getData('user_id')) ? $this->Auth->user('id') : $this->request->getData('user_id');
                    } else {
                        $video->user_id = empty($this->request->getData('user_id')) ? 0 : $this->request->getData('user_id');
                    }
                    $video->category = empty($this->request->getData('category')) ? 'Tip Video' : $this->request->getData('category');

                    $video->small_thumb = 'files/images/thumbs/small_video.png';
                    $video->medium_thumb = 'files/images/thumbs/medium_video.png';
                    $video->large_thumb = 'files/images/thumbs/large_video.png';

                    if ($this->Videos->save($video)) {
                        $this->responseData = $video;
                        $this->responseMessage = __('<b>' . $clientFileName . '</b> - Thank you! Uploaded successfully');
                        $this->responseCode = SUCCESS_CODE;
                    } else {
                        $this->responseMessage = $video->getErrors();
                    }

                } else {
                    $this->responseMessage = __("Only MP4 & WEBM formats are allowed.");
                }
            } else {
                $this->responseMessage = __("Video file is too large, file must be less than 50 MB in size.");
            }

        }
        echo $this->responseFormat();
        exit;
    }


    public
    function createThumb($thumbName = "small", $newWidth) {
        $imageUrl = SITE_URL . 'files/images/' . $this->fileName;
        $thumbPath = WWW_ROOT . 'files/images/thumbs/';

        $newHeight = $newWidth * ($this->actualHeight / $this->actualWidth);

        if (in_array(strtolower($this->fileExt), ['jpg', 'jpeg'])) {
            $ext = "jpeg";
        } else if (strtolower($this->fileExt) == "png") {
            $ext = "png";
        } else if (strtolower($this->fileExt) == "gif") {
            $ext = "gif";
        }

        $options = [
            'destinationPath' => $thumbPath,
            'image'           => ['type' => "image/" . $ext],
            'tmpname'         => $imageUrl,
            'name'            => $thumbName . "_" . $this->fileName,
            'width'           => $newWidth,
            'argHeight'       => $newHeight
        ];
        $this->thumb->create($options);

        return 'files/images/thumbs/' . $thumbName . "_" . $this->fileName;
    }


    public
    function getImages($page = 1) {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $offset = ($page - 1) * PAGE_LIMIT;
        $modelId = $this->Auth->user('id');
        $category = $this->request->getData('category');

        $images = $this->Images->find('all')
            ->where(['Images.category' => $category])
            ->order(['Images.created' => 'DESC'])
            ->offset($offset)
            ->limit(PAGE_LIMIT)
            ->all();


        if (!empty($images)) {
            $this->responseData['images'] = $images;
            $this->responseCode = SUCCESS_CODE;
        }
        echo $this->responseFormat();
        exit;
    }

    public
    function getApartmentImages($page = 1) {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $offset = ($page - 1) * PAGE_LIMIT;

        $join = [
            'table'      => 'apartment_images',
            'alias'      => 'ApartmentImages',
            'type'       => 'LEFT',
            'conditions' => 'ApartmentImages.image_id = Images.id',
        ];

        $imageCategories = [
            'Exterior',
            'Living',
            'Kitchen',
            'Bed',
            'Bath',
            'Business',
            'Clubhouse',
            'Fitness',
            'Pool',
            'Playground',
            'Parking'
        ];

        $images = $this->Images->find('all')
            ->join($join)
            ->where([
                'ApartmentImages.apartment_id' => $this->Auth->user('current_apartment'),
                'ApartmentImages.category IN'  => $imageCategories,
            ])
            ->group(['Images.id'])
            ->order(['Images.created' => 'DESC'])
            ->offset($offset)
            ->limit(PAGE_LIMIT)
            ->all();


        if (!empty($images)) {
            $this->responseData['images'] = $images;
            $this->responseCode = SUCCESS_CODE;
        }
        echo $this->responseFormat();
        exit;
    }

    public
    function crop() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;

        $cropFromImage = $this->Images->get($this->request->getData('id'));
        if (!empty($cropFromImage)) {
            $this->fileExt = pathinfo($cropFromImage->large_thumb, PATHINFO_EXTENSION);

            $this->fileName = uniqid() . "." . $this->fileExt;
            $imagePath = WWW_ROOT . 'files/images/' . $this->fileName;
            $imageUrl = SITE_URL . 'files/images/' . $this->fileName;

            $this->loadComponent('Thumb');
            $this->thumb = $this->Thumb;


            $options = [
                'destinationPath' => WWW_ROOT . 'files/images/',
                'image'           => [
                    'type' => "image/" . ((in_array(strtolower($this->fileExt), [
                            'jpg',
                            'jpeg'
                        ])) ? "jpeg" : "png")
                ],
                'tmpname'         => SITE_URL . $cropFromImage->large_thumb,
                'name'            => $this->fileName,
                'width'           => empty($this->request->getData('w')) ? 200 : $this->request->getData('w'),
                'argHeight'       => empty($this->request->getData('h')) ? 200 : $this->request->getData('h'),
                'imageX'          => empty($this->request->getData('x1')) ? 0 : $this->request->getData('x1'),
                'imageY'          => empty($this->request->getData('y1')) ? 0 : $this->request->getData('y1'),
                'imageCrop'       => true
            ];

            $this->thumb->create($options);

            $image = $this->Images->newEntity();

            $image->image = 'files/images/' . $this->fileName;
            $image->user_id = empty($this->request->getData('user')) ? 0 : $this->request->getData('user');
            $image->category = empty($this->request->getData('category')) ? 'Profile' : $this->request->getData('category');

            list($this->actualWidth, $this->actualHeight) = getimagesize($imageUrl);

            $image->small_thumb = $this->createThumb('small', SMALL_THUMB_WIDTH);
            $image->medium_thumb = $this->createThumb('medium', MEDIUM_THUMB_WIDTH);
            $image->large_thumb = $this->createThumb('large', LARGE_THUMB_WIDTH);

            if ($this->Images->save($image)) {
                $this->responseData = $image;
                $this->responseMessage = __('<b>' . $this->fileName . '</b> - Thank you! cropped successfully');
                $this->responseCode = SUCCESS_CODE;
            } else {
                $this->responseMessage = $image->getErrors();
            }
        }

        echo $this->responseFormat();
        exit;
    }

    /**
     * Delete method
     *
     * @param string|null $id Category Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public
    function delete($id = null) {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $this->request->allowMethod(['post', 'delete']);
        $image = $this->Images->get($id);
        if ($this->Images->delete($image)) {
            $this->responseMessage = __('Image Deleted');
            $this->responseCode = SUCCESS_CODE;
        }

        echo $this->responseFormat();
        exit;
    }

    public
    function videoMedia($type = "Tip", $category = "Tip Video", $userId = 0) {
        $this->viewBuilder()->setLayout(null);
        $this->set(compact('type', 'userId', 'category'));
    }

    public
    function test() {

    }

    public
    function testUpload() {
        $file = $this->request->getData('file');

        pr($file);

        $this->fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $this->fileName = "okokkokok." . $this->fileExt;
        $filePath = WWW_ROOT . 'files/' . $this->fileName;

        if (move_uploaded_file($file["tmp_name"], $filePath)) {
            $this->redirect(['action' => 'test']);

        }
    }
}

