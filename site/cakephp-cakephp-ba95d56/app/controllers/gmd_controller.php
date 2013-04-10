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
        $formats = array(
            'Metabolite' => array(
                'Metabolite Normalized',
                'Metabolite Raw'
            ),
            'Analyte' => array(
                'Analyte Normalized',
                'Analyte Raw'
            ),
            'MST' => array(
                'MST '
            ),
        );

        if (!empty($this->data)) {
            App::import('Core', 'HttpSocket');
            $hs = new HttpSocket();

            $tagfileid = $this->data['Gmd']['name'];
            if ( ! array_key_exists($tagfileid, $tagfileids)) {
                $this->Session->setFlash(__('Weird! the provided name does not appear in our database'));
            }
            else {
                $tagfileid = $tagfileids[ $tagfileid ];
                # TODO whitelist these values ?
                $format    = $this->data['Gmd']['format'];
                # TODO put url in settings
                $content = $hs->get("http://hanna/download.test.php?tagfileid=$tagfileid&format=$format");
                pr($content);
            }
        }

        $tags = array_keys($tagfileids);
        sort($tags);
        $tags = array_combine($tags, $tags);
        $this->set('tags', $tags);
        $this->set('formats', $formats);
    }

}
?>
