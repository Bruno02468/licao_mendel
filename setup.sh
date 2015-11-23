#!/usr/bin/sh

echo "Criando pastas..."
mkdir salas

echo "Criando arquivos padrão..."
touch ademir/atuadores/motd.txt
echo "[insira mensagem do dia aqui]" > ademir/atuadores/motd.txt

echo "Setando permissões..."
chmod -R 777 salas
chmod 777 ademir/atuadores/motd.txt

echo "Tudo pronto."
echo "Crie as pastas com os IDs das salas dentro de 'salas/'."
