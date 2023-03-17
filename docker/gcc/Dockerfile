FROM gcc:latest

RUN apt-get update -y
RUN apt-get install -y bc
RUN apt-get install dos2unix
WORKDIR /home/capacity/

ADD ./docker/script2.sh /bin/script2.sh
RUN chmod +x /bin/script2.sh
RUN dos2unix /bin/script2.sh

ENTRYPOINT ["sh", "/bin/script2.sh"]
