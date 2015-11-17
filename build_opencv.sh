curl -L 'https://github.com/Itseez/opencv/tarball/2.4' | tar xvzf -
mkdir -p Itseez-opencv-01b5971/release
cd Itseez-opencv-01b5971/release
cmake -D CMAKE_BUILD_TYPE=RELEASE -D CMAKE_INSTALL_PREFIX=/usr/local -D BUILD_PYTHON_SUPPORT=ON -D WITH_XINE=ON -D WITH_TBB=ON ..
make && make install
cd /
rm -rf Itseez-opencv-01b5971
