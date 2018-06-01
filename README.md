# chatbox
勉強用に作成したチャットアプリ。

```$xslt
$ git clone https://github.com/teru01/chatbox.git
$ docker-compose up
```

`http://chatbox`にアクセスすると利用できます。使い終わった後は、

```$xslt
$ docker-compose down -v
```
としてマウントしたボリュームを削除してください。
### TODO: 画像アップロード部分の不具合修正（ディレクトリパーミッションの問題？）
