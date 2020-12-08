<?php

namespace app\common\lib\ali;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Sms
{

    /**
     * @param $phone
     * @param $code
     * @return array
     * @throws ClientException
     */
    static public function SendSms($phone,$code)
    {
        AlibabaCloud::accessKeyClient('LTAI5OVoMFrYKUTh', 'Z5QI8SoEsV1OWKtNErji8Min4qGlb5')
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
        $smsCode = json_encode(['code'=>$code]);
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $phone,
                        'SignName' => "小松鼠智能回收",
                        'TemplateCode' => "SMS_159627402",
                        "TemplateParam"=>$smsCode
                    ],
                ])
                ->request();

            return ['status'=>200,'msg'=>$result->toArray()];
        } catch (ClientException $e) {
            return ['status'=>100,'msg'=>$e->getErrorMessage()];
        } catch (ServerException $e) {
            return ['status'=>100,'msg'=>$e->getErrorMessage()];
        }

    }

}