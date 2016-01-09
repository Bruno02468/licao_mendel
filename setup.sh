#!/usr/bin/sh

echo "Criando pastas..."
mkdir salas

echo "Criando arquivos padrão..."
touch ademir/atuadores/motd.txt
touch ademir/auth/.shadow
echo "[insira mensagem do dia aqui]" > ademir/atuadores/motd.txt

echo "Setando permissões..."
chmod -R 777 salas
chmod 777 ademir/atuadores/motd.txt
chmod -R 777 ademir/horarios/hors
chmod 77 ademir/auth/.shadow

echo "Tudo pronto."