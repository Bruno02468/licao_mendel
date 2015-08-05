#!/usr/bin/sh

echo "Criando pastas..."
mkdir salas
mkdir salas/1E

echo "Criando arquivo de MOTD..."
touch ademir/atuadores/motd.txt
echo "[insira mensagem do dia aqui]" > ademir/atuadores/motd.txt

echo "Setando permissões..."
chmod -R 777 salas
chmod 777 ademir/atuadores/motd.txt

echo "Tudo operante."
