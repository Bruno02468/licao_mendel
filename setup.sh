#!/usr/bin/sh

echo "Criando arquivos padrão..."
touch superademir/atuadores/motd.txt
touch extras/.supershadow
touch extras database.json
echo "[insira mensagem do dia aqui]" > superademir/atuadores/motd.txt

echo "Setando permissões..."
chmod 777 superademir/atuadores/motd.txt
chmod 777 extras/.supershadow
chmod 777 extras database.json

echo "Tudo pronto."