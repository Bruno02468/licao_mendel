#!/usr/bin/sh

echo "Criando pastas..."
mkdir salas
mkdir salas/1E

echo "Criando arquivos padrão..."
touch ademir/atuadores/motd.txt
echo "[insira mensagem do dia aqui]" > ademir/atuadores/motd.txt
touch extras/contador.txt

echo "Setando permissões..."
chmod -R 777 salas
chmod 777 ademir/atuadores/motd.txt
chmod 777 extras/contador.txt

echo "Tudo pronto."
