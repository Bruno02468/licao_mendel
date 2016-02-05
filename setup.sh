#!/usr/bin/sh

echo "Criando pastas..."
mkdir salas

echo "Criando arquivos padrão..."
touch ademir/atuadores/motd.txt
touch ademir/auth/.shadow
touch ademir/atuadores/ademires.txt
echo "[insira mensagem do dia aqui]" > ademir/atuadores/motd.txt

echo "Setando permissões..."
chmod -R 777 salas
chmod 777 ademir/atuadores/motd.txt
chmod -R 777 ademir/horarios/hors
chmod 777 ademir/auth/.shadow
chmod 777 ademir/atuadores/ademires.txt

echo "Tudo pronto."