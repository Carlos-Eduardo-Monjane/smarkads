Instalar docker

1 - Verificar se o appsettings.json é o correto
2 - Criar a imagem - docker build . -t "sendwebpushapi"
3 - Criar o arquivo .tar - docker save -o sendwebpushapi.tar sendwebpushapi
4 - Enviar o arquivo para o servidor via ftp para o /home/temp
5 - Parar o container - sudo docker container stop id_container
6 - deletar o container - sudo docker container rm id_container
7 - deletar a imagem - sudo docker image rm id_imagem
8 - Importar a imagem - sudo docker load -i sendwebpushapi.tar
9 - Rodar o container - sudo docker run -d --network="host" --restart always sendwebpushapi

Cron
1) * * * * * php /home/sendwebpush/public_html/artisan schedule:run
