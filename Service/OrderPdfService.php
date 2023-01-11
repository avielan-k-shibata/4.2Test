<?php

namespace Plugin\Test\Service;
use Eccube\Entity\Shipping;

class OrderPdfService extends \Eccube\Service\OrderPdfService
{

    /**
     * 注文情報からPDFファイルを作成する.
     *
     * @param array $formData
     *                        [KEY]
     *                        ids: 注文番号
     *                        issue_date: 発行日
     *                        title: タイトル
     *                        message1: メッセージ1行目
     *                        message2: メッセージ2行目
     *                        message3: メッセージ3行目
     *                        note1: 備考1行目
     *                        note2: 備考2行目
     *                        note3: 備考3行目
     *
     * @return bool
     */
    public function makePdf(array $formData)
    {
        // 発行日の設定
        $this->issueDate = '作成日: '.$formData['issue_date']->format('Y年m月d日');
        // ダウンロードファイル名の初期化
        $this->downloadFileName = null;

        // データが空であれば終了
        if (!$formData['ids']) {
            return false;
        }

        // 出荷番号をStringからarrayに変換
        $ids = explode(',', $formData['ids']);

        foreach ($ids as $id) {
            $this->lastOrderId = $id;

            // 出荷番号から出荷情報を取得する
            /** @var Shipping $Shipping */
            $Shipping = $this->shippingRepository->find($id);
            if (!$Shipping) {
                // 出荷情報の取得ができなかった場合
                continue;
            }

            // テンプレートファイルを読み込む
            $Order = $Shipping->getOrder();
            if ($Order->isMultiple()) {
                // 複数配送の時は読み込むテンプレートファイルを変更する
                $userPath = $this->eccubeConfig->get('eccube_html_admin_dir').'/assets/pdf/nouhinsyo_multiple.pdf';
            } else {
                $userPath = $this->eccubeConfig->get('eccube_html_admin_dir').'/assets/pdf/nouhinsyo.pdf';
            }
            $this->setSourceFile($userPath);

            // PDFにページを追加する
            $this->addPdfPage();

            // タイトルを描画する
            $this->renderTitle($formData['title']);

            // 店舗情報を描画する
            $this->renderShopData();

            // 注文情報を描画する
            if($formData['title2'] == 1){
            $this->renderOrderData($Shipping);
            }else{
                $this->renderTest($Shipping, $formData);
            }
            // メッセージを描画する
            $this->renderMessageData($formData);

            // 出荷詳細情報を描画する
            $this->renderOrderDetailData($Shipping);

            // 備考を描画する
            $this->renderEtcData($formData);

            
        }

        return true;
    }

    /**
     * メッセージを設定する.
     *
     * @param array $formData
     */
    protected function renderMessageData(array $formData)
    {
        $ids = explode(',', $formData['ids']);
        $this->lfText(27, 70, $formData['message1'], 8); // メッセージ1
        $this->lfText(27, 74, $formData['message2'], 8); // メッセージ2
        $this->lfText(27, 78, $formData['message3'], 8); // メッセージ3

        foreach ($ids as $id) {
            $Shipping = $this->shippingRepository->find($id);
            if (!$Shipping) {
                // 出荷情報の取得ができなかった場合
                continue;
            }
            $this->lfText(27, 84, $Shipping->getName01(), 8); // メッセージ3
            if($formData['title2'] == 1){
                $this->lfText(27, 82, "PPPP", 8); // メッセージ3
            }
        }

        
    }

        /**
     * 購入者情報を設定する.
     * @param array $formData
     * @param Shipping $Shipping
     */
    protected function renderOrderData(Shipping $Shipping)
    {
        // 基準座標を設定する
        $this->setBasePosition();

        // フォント情報のバックアップ
        $this->backupFont();

        // =========================================
        // 購入者情報部
        // =========================================

        $Order = $Shipping->getOrder();

        // 購入者都道府県+住所1
        // $text = $Order->getPref().$Order->getAddr01();
        $text = $Shipping->getPref().$Shipping->getAddr01();
        $this->lfText(27, 47, $text, 10);
        $this->lfText(27, 51, $Shipping->getAddr02(), 10);// 購入者住所2

        // 購入者氏名
        if (null !== $Shipping->getCompanyName()) {
            // 会社名
            $text = $Shipping->getCompanyName();
            $this->lfText(27, 57, $text, 11);
            // 氏名
            $text = $Shipping->getName01().'　'.$Shipping->getName02().'　様';
            $this->lfText(27, 63, $text, 11);
        } else {
            $text = $Shipping->getName01().'　'.$Shipping->getName02().'　様';
            $this->lfText(27, 59, $text, 11);
            $this->lfText(27, 62, $text, 11);
        }

        // =========================================
        // お買い上げ明細部
        // =========================================
        $this->SetFont(self::FONT_SJIS, '', 10);

        // ご注文日
        $orderDate = $Order->getCreateDate()->format('Y/m/d H:i');
        if ($Order->getOrderDate()) {
            $orderDate = $Order->getOrderDate()->format('Y/m/d H:i');
        }

        $this->lfText(25, 125, $orderDate, 10);
        // 注文番号
        $this->lfText(25, 135, $Order->getOrderNo(), 10);

        // 総合計金額
        if (!$Order->isMultiple()) {
            $this->SetFont(self::FONT_SJIS, 'B', 15);
            $paymentTotalText = $this->eccubeExtension->getPriceFilter($Order->getPaymentTotal());

            $this->setBasePosition(120, 95.5);
            $this->Cell(5, 7, '', 0, 0, '', 0, '');
            $this->Cell(67, 8, $paymentTotalText, 0, 2, 'R', 0, '');
            $this->Cell(0, 45, '', 0, 2, '', 0, '');
        }

        // フォント情報の復元
        $this->restoreFont();
    }
        /**
     * 購入者情報を設定する.
     * @param array $formData
     * @param Shipping $Shipping
     */
    protected function renderTest(Shipping $Shipping, array $formData)
    {
        if($formData['title2'] == 2){
            // 購入者氏名
            if (null !== $Shipping->getCompanyName()) {
                // 会社名
                $text = $Shipping->getCompanyName();
                $this->lfText(27, 57, $text, 11);
                // 氏名
                $text = $Shipping->getName01().'　'.$Shipping->getName02().'　様';
                $this->lfText(27, 63, $text, 11);
            } else {
                $text = $Shipping->getName01().'　'.$Shipping->getName02().'　様';
                $this->lfText(27, 59, $text, 11);
                $this->lfText(27, 62, $text, 11);
            }
        }
    }
}