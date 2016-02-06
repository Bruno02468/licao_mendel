#!/usr/bin/sh

echo "Criando pastas..."
mkdir salas

echo "Criando arquivos padrão..."
touch superademir/atuadores/motd.txt
touch superademir/auth/.shadow
touch superademir/atuadores/ademires.txt
echo "[insira mensagem do dia aqui]" > superademir/atuadores/motd.txt

echo "Setando permissões..."
chmod -R 777 salas
chmod 777 superademir/atuadores/motd.txt
chmod -R 777 ademir/horarios/hors
chmod 777 superademir/auth/.shadow
chmod 777 superademir/atuadores/ademires.txt

echo "Tudo pronto."