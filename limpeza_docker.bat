@echo off
echo Limpando containers parados...
docker container prune -f

echo Limpando imagens não utilizadas...
docker image prune -a -f

echo Limpando volumes não utilizados...
docker volume prune -f

echo Limpando redes não utilizadas...
docker network prune -f

echo Limpando cache de builds...
docker builder prune -f

echo Limpeza concluída!
docker system df
pause