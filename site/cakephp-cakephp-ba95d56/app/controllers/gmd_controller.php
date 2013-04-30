<?php
class GmdController extends AppController {

    var $name = 'Gmd';
    var $uses = null;

    function index() { }

    function download() {
        # TODO maybe put into a model anyway?
        $tagfileids = array(
             'Calibration FW' =>         'B5DA5C01-5DC7-426A-A779-01ECD9FF74B5',
             'JKI Shelter 2011' =>       '697743D4-ECA9-41FD-909F-21D70D8F03AB',
             'JKI GWH2' =>               '9E64F661-5EE5-4B56-B5A6-4D37EF0C2F13',
             'TROSTTest1.2' =>           'A58437A0-10C7-491C-B234-5FB8F3DA45A4',
             'JKI GWH1' =>               '80339A4F-642C-4DA7-BB45-649380A16E60',
             'Feld JKI 2012' =>          '64826B1C-6290-4FFF-9C97-72C9EEBB6F28',
             'Field Trial Dethlingen' => '7B5E2E48-258B-4172-84E4-8DF5E8FC5E62',
             'TROSTTest2' =>             'E1009769-FBA5-42DC-AACE-9EE5725305E4',
             'Calibration Volume 1' =>   '18FC6032-FB5B-411B-88FA-A805CD993723',
             'Reproducibility QC 2nd' => '23879D60-E01D-4ADF-A978-B5D62DFDF0BB',
             'Pruef1' =>                 '8B18B746-1405-487A-9200-E0614D4A6392',
             'Reproducibility QC 1st' => '135E180C-3A77-4736-80C9-ED241668E536',
             'Calibration Volume 2' =>   '1FE678D1-CE61-4464-9FC1-FE83712B03E9'
        );
        $grouped_formats = array(
            'Metabolite' => array(
                0 => 'MetaboliteNorm',
                1 => 'MetaboliteRaw'
            ),
            'Analyte' => array(
                2 => 'AnalyteNorm',
                3 => 'AnalyteRaw'
            ),
            'MST' => array(
                4 => 'MstIntensities'
            ),
        );

        if (!empty($this->data)) {
            $tagfileid = $this->data['Gmd']['name'];
            if ( ! array_key_exists($tagfileid, $tagfileids)) {
                $this->Session->setFlash(__('Weird! the provided name does not appear in our database'));
            }
            else {
                # import the URL 'get' functionality
                App::import('Core', 'HttpSocket');
                $hs = new HttpSocket();

                # get the right tagfileid
                $tagfileid = $tagfileids[ $tagfileid ];

                # flatten the formats array struct for easy key-based lookup
                $formats = call_user_func_array('array_merge', $grouped_formats);
                $format  = $formats[ $this->data['Gmd']['format'] ];

                # TODO put url in settings
                $content = $hs->get("http://gmd.mpimp-golm.mpg.de/webservices/GetTagFileProfile.ashx?TagFileId=$tagfileid&ProfileType=$format");
                #$content_local = $hs->get("http://hanna/download.test.php?TagListId=$tagfileid&ProfileType=$format");
                #pr($hs->response);
                #pr($content);
                if ($hs->response['status']['code'] != 200) {
                    $this->Session->setFlash($hs->response['raw']['status-line']);
                    if (Configure::read('debug') > 0) {
                        debug($hs->response);
                    }
                }
                else {
                    $this->layout = 'ajax';
                    header('Content-type: ' . $hs->response['header']['Content-Type']);
                    header('Content-lenght: ' . strlen($content));
                    #header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Content-disposition: ' . $hs->response['header']['Content-Disposition']);
                    print($content);
                    exit();
                }
            }
        }

        $tags = array_keys($tagfileids);
        sort($tags);
        $tags = array_combine($tags, $tags);
        $this->set('tags', $tags);
        $this->set('formats', $grouped_formats);
    }

}
?>
