mkdir -p /opencv
curl -L 'https://github.com/Itseez/opencv/tarball/2.4' | tar xvzf - -C FOLDER --strip-components=1
mkdir -p /opencv/release
cd /opencv/release
cmake -D CMAKE_BUILD_TYPE=RELEASE -D CMAKE_INSTALL_PREFIX=/usr/local -D BUILD_PYTHON_SUPPORT=ON -D WITH_XINE=ON -D WITH_TBB=ON ..
make && make install
cd /
rm -rf opencv
